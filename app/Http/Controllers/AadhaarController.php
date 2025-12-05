<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AadhaarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aadhaar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Request Data Before Validation:', $request->all());

        // Validate the Aadhaar number
        $validated = $request->validate([
            'aadhaar_number' => 'required|digits:12',
        ]);

        Log::info('Validated Data:', $validated);

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // OTP expiration time (e.g., 10 minutes from now)
        $otpExpiration = Carbon::now()->addMinutes(10);  // Adjust this time as per your requirement

        // If validation passes, continue with processing (your existing logic here)
        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Save the Aadhaar number and OTP in the 'documents' table
            $document = new Document;
            $document->user_id = Auth::id();  // Assuming you want to store the current user ID
            $document->aadhar_card_number = $validated['aadhaar_number'];
            $document->aadhar_card_otp = $otp;
            $document->aadhar_card_otp_expired = $otpExpiration;

            // Attempt to save the document record
            if (! $document->save()) {
                throw new \Exception('Failed to save Aadhaar number and OTP.');
            }

            // Commit the transaction
            DB::commit();

            // Log success
            Log::info('Aadhaar Number and OTP Stored:', [
                'aadhaar_number' => $validated['aadhaar_number'],
                'aadhar_card_otp' => $otp,
                'aadhar_card_otp_expired' => $otpExpiration,
            ]);

            // Return success response with OTP expiration message
            return redirect()->route('aadhaar_verify_otp')->with('success', 'Aadhaar number stored successfully. OTP sent for verification.');

        } catch (\Exception $e) {
            // Rollback transaction in case of an error
            DB::rollback();

            Log::error('Error during Aadhaar processing: '.$e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['error' => 'Failed to store Aadhaar number. Please try again later.']);
        }
    }

    /**
     *  Verify the OTP entered by the user.
     */
    public function verifyOtp(Request $request)
    {
        // Validate the OTP input
        $request->validate([
            'otp' => 'required|array|size:6', // Ensure there are exactly 6 OTP digits
            'otp.*' => 'required|numeric|digits:1', // Each OTP digit should be numeric and exactly one digit
        ]);

        // Combine the OTP digits into a string
        $enteredOtp = implode('', $request->otp);

        // Fetch the stored document record by Aadhaar number (or another identifier if needed)
        $document = Document::where('aadhar_card_number', $request->aadhaar_number)->first();

        // Check if the document exists
        if (! $document) {
            return back()->withErrors(['error' => 'Aadhaar number not found.']);
        }

        // Check if the OTP matches and is not expired
        if ($document->aadhar_card_otp !== $enteredOtp) {
            return back()->withErrors(['error' => 'Invalid OTP entered. Please try again.']);
        }

        // Check if OTP is expired
        if (Carbon::now()->gt($document->aadhar_card_otp_expired)) {
            return back()->withErrors(['error' => 'OTP has expired. Please request a new OTP.']);
        }

        // OTP is valid and not expired, so proceed to the next step
        return redirect()->route('upload_aadhaar_doc')->with('success', 'OTP verified successfully! Proceed to upload Aadhaar document.');
    }

    public function uploadAadhaarDocument(Request $request)
    {
        // Validate the uploaded file
        $validated = $request->validate([
            'aadhaar_card_image' => 'required|mimes:jpg,png,pdf|max:10240', // Max size 10MB
        ]);

        // Handle the file upload
        if ($request->hasFile('aadhaar_card_image')) {
            $file = $request->file('aadhaar_card_image');

            // Generate a unique filename with the current timestamp
            $filename = 'aadhaar_card_'.time().'.'.$file->getClientOriginalExtension();

            // Store the file in the 'private_uploads/aadhar_card' folder inside 'storage/app'
            $path = $file->storeAs('private_uploads/aadhar_card', $filename);

            // Save only the filename in the database (no directory path)
            $document = new Document;
            $document->user_id = Auth::id();
            $document->aadhar_card_image = $filename;  // Store only the image name in the database
            $document->save();

            // Optionally, you can also return a success message
            return redirect()->route('aadhaar1')->with('success', 'Aadhaar card uploaded successfully.');
        }

        // If no file is uploaded, return error
        return back()->with('error', 'Failed to upload Aadhaar card.');
    }

    /**
     *  Generate and download the Aadhaar verification receipt as a PDF.
     */
    public function downloadReceipt(Request $request)
    {
        log::info($request->all());
        try {
            $document = null;

            // 1. Document Retrieval Logic
            // Priority: Aadhaar Number in Request > Authenticated User ID > Latest Document
            if ($request->has('aadhaar_number')) {
                $document = Document::where('aadhar_card_number', $request->aadhaar_number)
                    ->whereNotNull('aadhar_card_number')
                    ->latest()
                    ->first();
            } elseif (Auth::check()) {
                $userId = Auth::id();
                $document = Document::where('user_id', $userId)
                    ->whereNotNull('aadhar_card_number')
                    ->latest()
                    ->first();
            } else {
                $document = Document::whereNotNull('aadhar_card_number')
                    ->latest()
                    ->first();
            }

            if (! $document) {
                return back()->withErrors(['error' => 'Document not found. Please complete Aadhaar verification first.']);
            }

            // Get User Name
            $userName = $document->user_id ? ($document->user->name ?? 'N/A') : 'N/A';

            // 2. Image Retrieval and Base64 Conversion
            $imageBase64 = null;
            $imageMimeType = null;
            $imageFileName = $document->aadhar_card_image;

            if ($imageFileName) {
                $imagePath = storage_path('app/private/private_uploads/aadhar_card/'.$imageFileName);

                if (file_exists($imagePath)) {
                    // Check if the file is readable
                    if (is_readable($imagePath)) {
                        $imageData = file_get_contents($imagePath);
                        $imageBase64 = base64_encode($imageData);

                        // Get mime type using fileinfo extension (must be enabled in php.ini)
                        if (function_exists('finfo_open')) {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $imageMimeType = finfo_file($finfo, $imagePath);
                            finfo_close($finfo);
                        } else {
                            // Fallback if fileinfo is not available (less reliable)
                            $imageMimeType = mime_content_type($imagePath);
                        }
                    } else {
                        Log::error('File found but not readable: '.$imagePath);
                    }
                } else {
                    Log::error('File NOT found at path: '.$imagePath);
                }
            } else {
                Log::warning('Aadhaar image filename is missing in the database record for document ID: '.$document->id);
            }

            // 3. Prepare Data for PDF
            $maskedAadhaar = ! empty($document->aadhar_card_number) && strlen($document->aadhar_card_number) >= 8
                        ? substr($document->aadhar_card_number, 0, 4).' XXXX '.substr($document->aadhar_card_number, -4)
                        : 'XXXX XXXX XXXX';

            $userData = [
                'name' => $userName,
                'aadhaar_number_full' => $document->aadhar_card_number ?? 'N/A',
                'aadhaar_number_masked' => $maskedAadhaar,
                'verification_date' => $document->created_at ? $document->created_at->format('d/m/Y') : now()->format('d/m/Y'),
                'verification_time' => $document->created_at ? $document->created_at->format('H:i:s') : now()->format('H:i:s'),
                'aadhar_card_image' => $imageBase64,
                'aadhar_card_image_mime' => $imageMimeType,
                'response_code' => strtoupper(substr(md5($document->id.$document->aadhar_card_number.time()), 0, 32)),
            ];
            // dd($userData);
            // 4. Generate and Download PDF
            $pdf = Pdf::loadView('receipt', $userData);
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('enable-local-file-access', true);

            return $pdf->download('aadhaar_verification_receipt.pdf');
            dd($userData);

        } catch (\Exception $e) {
            Log::error('PDF Download Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['error' => 'Failed to generate PDF. Please try again later.']);
        }
    }

    /**
     * Show show_verify_otp resource.
     */
    public function showOtpForm()
    {
        return view('verify_aadhaar');
    }

    /**
     * Show upload_aadhaar_document resource.
     */
    public function uploadaadhaarform()
    {
        return view('upload_aadhaar_document');
    }

    /**
     * Show aadhaar_data_reviewform resource.
     */
    public function aadhaar_data_review()
    {
        return view('aadhaar_data_review');
    }

    /**
     * Show aadhaar_verification_form resource.
     */
    public function aadhaar_verification_form()
    {
        return view('aadhaar_verification_comp');
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
}
