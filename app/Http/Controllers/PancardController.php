<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\AccountCreationService;
use App\Services\CibilScoreService;
use App\Services\PanExtractionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PancardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function pan_not_linked()
    {
        return view('pan_not_linked');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Log the incoming request data for debugging
        Log::info('Pan card Request Data Before Validation:', $request->all());

        // Validate the PAN card number with the required format
        $validated = $request->validate([
            'pan_card_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',  // PAN format: XXXXX1234X
        ]);

        // Log validated data for debugging
        Log::info('Validated Data:', $validated);

        // Generate a random 6-digit OTP for PAN card verification
        $otp = rand(100000, 999999);

        // OTP expiration time (e.g., 10 minutes from now)
        $otpExpiration = Carbon::now()->addMinutes(10);  // Adjust the expiration time if needed

        try {
            // Start Transaction
            DB::beginTransaction();

            $document = null;

            // Try to find existing document to merge with (Prioritize Logged In User)
            if (Auth::check()) {
                $document = Document::where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }

            // If no user doc, maybe try finding by just-verified Aadhaar in Session? (Optional, but let's stick to Auth or New)

            if ($document) {
                // Update existing document
                Log::info('Merging PAN OTP into existing document', ['doc_id' => $document->id]);
                $document->pan_card_number = $validated['pan_card_number'];
                $document->pan_card_otp = $otp;
                $document->pan_card_otp_expired = $otpExpiration;
            } else {
                // Create NEW document entry (fallback)
                $document = new Document;
                $document->user_id = Auth::check() ? Auth::id() : null;
                $document->pan_card_number = $validated['pan_card_number'];
                $document->pan_card_otp = $otp;
                $document->pan_card_otp_expired = $otpExpiration;
            }

            // Attempt to save the document record
            if (!$document->save()) {
                // Log error if saving fails
                Log::error('Failed to save PAN card data:', [
                    'pan_card_number' => $validated['pan_card_number'],
                ]);
                throw new \Exception('Failed to save PAN card number and OTP.');
            }

            // Fetch and update CIBIL Score
            try {
                $cibilService = new CibilScoreService();
                $cibilData = $cibilService->fetchCibilScore($validated['pan_card_number']);

                if ($cibilData['success']) {
                    $document->cibil_score = $cibilData['data']['cibil_score'];
                    $document->save();

                    Log::info('CIBIL Score updated for PAN:', [
                        'pan' => $validated['pan_card_number'],
                        'score' => $document->cibil_score
                    ]);
                }
            } catch (\Exception $e) {
                // Do not fail the transaction if CIBIL fails, just log it
                Log::error('Failed to fetch CIBIL score: ' . $e->getMessage());
            }

            // Commit the transaction
            DB::commit();

            // Log the stored PAN card number and OTP for debugging
            Log::info('PAN Card Number and OTP Stored:', [
                'pan_card_number' => $validated['pan_card_number'],
                'pan_card_otp' => $otp,
                'pan_card_otp_expired' => $otpExpiration,
            ]);

            // Return success response as JSON
            return response()->json(['success' => true, 'message' => 'PAN card number stored successfully. OTP sent for verification.']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();

            // Log the error message
            Log::error('Error during PAN card processing: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);

            // Return error response
            return response()->json(['error' => 'Failed to store your PAN number. Please try again later.'], 500);
        }
    }

    public function uploadPanDocument(Request $request)
    {
        // dd('uploadPanDocument called', $request->all());
        // Validate the uploaded file
        $validated = $request->validate([
            'pan_card_image' => 'required|mimes:jpg,png,pdf|max:10240',  // Max size 10MB
        ]);

        // Handle the file upload
        if ($request->hasFile('pan_card_image')) {
            $file = $request->file('pan_card_image');

            // Generate a unique filename with the current timestamp
            $filename = 'pan_card_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file in the 'private_uploads/pan_card' folder inside 'storage/app'
            $path = $file->storeAs('private_uploads/pan_card', $filename);

            // Get the PAN number from request or latest document
            // If request has it, use it.
            // If not, try to extract it from the image using OCR
            $panNumber = $request->input('pan_card_number');

            $extractedData = null;
            // Try OCR Extraction (Always run to get metadata like Name/DOB)
            try {
                $panExtractionService = new PanExtractionService();
                // Use Storage::path() to get the correct absolute path based on the disk configuration
                $fullPath = Storage::disk('local')->path($path);

                $extractedData = $panExtractionService->extractFromImage($fullPath);

                if ($extractedData && !empty($extractedData['pan_number'])) {
                    // Only override PAN if it wasn't provided in request
                    if (!$panNumber) {
                        $panNumber = $extractedData['pan_number'];
                        Log::info('PAN Number extracted via OCR:', ['pan' => $panNumber]);
                    } else {
                        Log::info('PAN Number present in request, OCR used for verification/metadata:', ['pan_request' => $panNumber, 'pan_ocr' => $extractedData['pan_number']]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to extract PAN data: ' . $e->getMessage());
            }

            // Fallback to existing logic if still no PAN
            if (!$panNumber) {
                $panNumber = Document::whereNotNull('pan_card_number')
                    ->latest()
                    ->value('pan_card_number');
            }

            if (!$panNumber) {
                return back()->with('error', 'PAN number could not be found or extracted. Please enter PAN number correctly.');
            }

            // Find existing document to update
            $document = null;
            if (Auth::check()) {
                $document = Document::where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }

            // If not found by ID (maybe session expired?), find by PAN Number if we just saved it in OTP step
            if (!$document && $panNumber) {
                $document = Document::where('pan_card_number', $panNumber)
                    ->latest()
                    ->first();
            }

            if (!$document) {
                // Fallback: Create NEW document entry
                $document = new Document;
                $document->pan_card_number = $panNumber;
            } else {
                // Ensure PAN number is consistent
                if (!$document->pan_card_number) {
                    $document->pan_card_number = $panNumber;
                }
            }

            $document->pan_card_image = $filename;
            $document->save();  // Save immediately

            // Save other extracted details if available (Temporarily saving to customer_name for review display)
            if ($extractedData) {
                if (!empty($extractedData['name'])) {
                    $document->customer_name = $extractedData['name'];
                }

                // Update Customer/User record with extracted data if available and currently empty
                $user = Auth::user();
                if ($user && $user->customer) {
                    $customer = $user->customer;
                    $updated = false;

                    // Update Name if generic
                    if (!empty($extractedData['name']) && ($customer->name !== $extractedData['name'])) {
                        // Optional: logic to only update if name is "User" or empty
                        // For now, let's assume OCR is authority for this flow
                        // $customer->name = $extractedData['name'];
                        // $updated = true;
                    }

                    // Update DOB if missing
                    if (!empty($extractedData['date_of_birth']) && !$customer->date_of_birth) {
                        try {
                            $dob = Carbon::createFromFormat('d/m/Y', $extractedData['date_of_birth'])->format('Y-m-d');
                            $customer->date_of_birth = $dob;
                            $updated = true;
                        } catch (\Exception $e) {
                            Log::warning('Failed to parse extracted DOB: ' . $extractedData['date_of_birth']);
                        }
                    }

                    if ($updated) {
                        $customer->save();
                    }
                }
            }

            // Store extracted data in Session for the Review Page to display
            // This ensures the user sees exactly what was just uploaded/extracted
            if ($extractedData) {
                session()->put('pan_extracted_data', $extractedData);
            }

            // Check if Aadhaar is also uploaded
            $aadhaarDocument = Document::whereNotNull('aadhar_card_number')
                ->whereNotNull('aadhar_card_image')
                ->latest()
                ->first();

            $accountService = new AccountCreationService();

            if ($aadhaarDocument) {
                // Both Aadhaar and PAN exist, create or get accounts (and merge PAN if needed)
                $accounts = $accountService->createOrGetAccountsFromAadhaar(
                    $aadhaarDocument->aadhar_card_number,
                    $panNumber  // Pass PAN number to update existing account
                );

                if ($accounts) {
                    // Link document to accounts
                    $document->user_id = Auth::check() ? Auth::id() : ($accounts['user']->id ?? null);
                    $document->customer_id = $accounts['customer']->id;
                    $document->customer_name = $accounts['user']->name;
                    $document->aadhar_card_number = $aadhaarDocument->aadhar_card_number;  // Link Aadhaar to PAN document
                    $document->save();

                    Log::info('PAN document saved and accounts linked', [
                        'document_id' => $document->id,
                        'user_id' => $accounts['user']->id,
                        'customer_id' => $accounts['customer']->id,
                        'pan' => $panNumber,
                    ]);

                    // Auto-login the user
                    if ($accounts['user']) {
                        Auth::login($accounts['user']);
                    }
                } else {
                    // If account creation failed, still save document
                    $document->user_id = Auth::check() ? Auth::id() : null;
                    $document->save();
                }
            } else {
                // Only PAN uploaded
                // If user is logged in, we should still try to link this PAN to them nicely
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user->aadhaar_card_number) {
                        // They have aadhaar, so we can run the merge logic
                        $accounts = $accountService->createOrGetAccountsFromAadhaar(
                            $user->aadhaar_card_number,
                            $panNumber
                        );
                        if ($accounts) {
                            $document->user_id = $accounts['user']->id;
                            $document->customer_id = $accounts['customer']->id;
                            $document->customer_name = $accounts['user']->name;
                            $document->aadhar_card_number = $accounts['user']->aadhaar_card_number;
                        } else {
                            $document->user_id = $user->id;
                        }
                    } else {
                        // No aadhaar yet, just link to user
                        $document->user_id = $user->id;
                        // Optionally update user's pan directly here if needed, but service does it better
                        $user->pan_card_number = $panNumber;
                        $user->save();
                        if ($user->customer) {
                            $user->customer->pan_card_number = $panNumber;
                            $user->customer->save();
                        }
                    }
                } else {
                    // Not logged in, no Aadhaar doc found... just save doc
                    $document->user_id = null;
                }
                $document->save();
            }

            // Fetch and update CIBIL Score (if not already set)
            if (!$document->cibil_score) {
                try {
                    $cibilService = new CibilScoreService();
                    $cibilData = $cibilService->fetchCibilScore($panNumber);

                    if ($cibilData['success']) {
                        $document->cibil_score = $cibilData['data']['cibil_score'];
                        $document->save();  // Save again with score
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to fetch CIBIL score in upload: ' . $e->getMessage());
                }
            }

            // Optionally, you can also return a success message
            return redirect()->route('pan_data_review')->with('success', 'PAN card uploaded successfully.');
        }

        // If no file is uploaded, return error
        return back()->with('error', 'Failed to upload PAN card.');
    }

    /**
     * Show pan card number enter form resource.
     */
    public function showpanform()
    {
        return view('pan');
    }

    /**
     * Show upload_pancard_document from resource.
     */
    public function upload_pan_document()
    {
        return view('upload_pan_document');
    }

    /**
     * Show pancard_data(data_fatch)_document from resource.
     */
    public function Verify_pancard_form()
    {
        return view('Verify_pan');
    }

    /**
     * Show pancard_data_reviewform resource.
     */
    public function pan_data_reviewform()
    {
        $user = Auth::user();
        $document = null;

        if ($user) {
            $document = Document::where('user_id', $user->id)->latest()->first();
        } else {
            // Fallback for non-logged in users (demo purpose)
            $document = Document::latest()->first();
        }

        if (!$document) {
            return redirect()->route('pan')->with('error', 'No PAN document found.');
        }

        // 1. Try to get data from Session (Freshly extracted from Upload)
        $sessionData = session('pan_extracted_data');

        // 2. Prepare Data (Prioritize Session > DB)
        $data = [
            'pan_number' => $sessionData['pan_number'] ?? $document->pan_card_number,
            'full_name' => $sessionData['name'] ?? $document->customer_name ?? $user->name ?? 'N/A',
            'dob' => $sessionData['date_of_birth'] ?? $user->customer->date_of_birth ?? 'N/A',
            'father_name' => $sessionData['father_name'] ?? 'N/A',  // OCR might provide this
        ];

        // Format DOB if it comes from DB (YYYY-MM-DD from user->customer)
        // Session DOB is usually already DD/MM/YYYY from OCR
        if (empty($sessionData['date_of_birth']) && $data['dob'] !== 'N/A' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['dob'])) {
            try {
                $data['dob'] = Carbon::parse($data['dob'])->format('d/m/Y');
            } catch (\Exception $e) {
            }
        }

        // Simulate Father's Name if missing (for demo "wow" factor)
        // if ($data['father_name'] === 'N/A' && $data['full_name'] !== 'N/A') {
        //     $parts = explode(' ', $data['full_name']);
        //     $lastName = end($parts);
        //     $data['father_name'] = 'Ram ' . $lastName;
        // }

        return view('pan_data_review', $data);
    }

    /**
     * Show pancard_verification_comp_form resource.
     */
    public function pan_verification_comp()
    {
        return view('pan_verification_comp');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Generate and download the full CIBIL report PDF.
     */
    public function downloadFullReport()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch User details
        $customer = $user->customer;
        $panNumber = $user->pan_card_number ?? ($customer->pan_card_number ?? 'N/A');

        // Fetch or simulate Score
        $score = 750;
        // Try to get stored score first
        // $doc = Document::where('user_id', $user->id)->whereNotNull('cibil_score')->latest()->first();
        // if ($doc) { $score = $doc->cibil_score; }

        // Or re-fetch based on simple logic (simulate free API consistency)
        if ($panNumber && $panNumber !== 'N/A') {
            $service = new CibilScoreService();
            $result = $service->fetchCibilScore($panNumber);
            if ($result['success']) {
                $score = $result['data']['cibil_score'];
            }
        }

        // Determine Band and Color
        $scoreColor = '#dc3545';  // Red
        $scoreBand = 'Poor';
        if ($score >= 750) {
            $scoreColor = '#198754';  // Green
            $scoreBand = 'Excellent';
        } elseif ($score >= 650) {
            $scoreColor = '#ffc107';  // Yellow/Orange
            $scoreBand = 'Good';
        }

        // Format Data
        $data = [
            'user' => $user,
            'panNumber' => $panNumber,
            'dob' => ($customer && $customer->date_of_birth) ? Carbon::parse($customer->date_of_birth)->format('d-M-Y') : 'N/A',
            'gender' => $customer->gender ?? 'N/A',
            'address' => $customer->address ?? 'Not Recorded',
            'aadhaarMasked' => $user->aadhaar_card_number ? 'XXXXXXXX' . substr($user->aadhaar_card_number, -4) : 'N/A',
            'score' => $score,
            'scoreColor' => $scoreColor,
            'scoreBand' => $scoreBand,
            'reportDate' => now()->format('d M, Y H:i A'),
            'referenceId' => 'CIB-' . strtoupper(uniqid()),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cibil_report_pdf', $data);

        // Sanitize filename to remove invalid characters like '/' (from N/A)
        $safePan = str_replace(['/', '\\'], '-', $panNumber);
        return $pdf->download('Official_CIBIL_Report_' . $safePan . '.pdf');
    }
}
