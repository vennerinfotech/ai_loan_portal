<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PancardController extends Controller
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
            'pan_card_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', // PAN format: XXXXX1234X
        ]);

        // Log validated data for debugging
        Log::info('Validated Data:', $validated);

        // Generate a random 6-digit OTP for PAN card verification
        $otp = rand(100000, 999999);

        // OTP expiration time (e.g., 10 minutes from now)
        $otpExpiration = Carbon::now()->addMinutes(10);  // Adjust the expiration time if needed

        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Save the PAN card number and OTP in the 'documents' table
            $document = new Document;
            $document->user_id = Auth::id();
            $document->pan_card_number = $validated['pan_card_number'];
            $document->pan_card_otp = $otp;
            $document->pan_card_otp_expired = $otpExpiration;

            // Attempt to save the document record
            if (! $document->save()) {
                // Log error if saving fails
                Log::error('Failed to save PAN card data:', [
                    'pan_card_number' => $validated['pan_card_number'],
                ]);
                throw new \Exception('Failed to save PAN card number and OTP.');
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
            Log::error('Error during PAN card processing: '.$e->getMessage(), [
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
            'pan_card_image' => 'required|mimes:jpg,png,pdf|max:10240', // Max size 10MB
        ]);

        // Handle the file upload
        if ($request->hasFile('pan_card_image')) {
            $file = $request->file('pan_card_image');

            // Generate a unique filename with the current timestamp
            $filename = 'pan_card_'.time().'.'.$file->getClientOriginalExtension();

            // Store the file in the 'private_uploads/pan_card' folder inside 'storage/app'
            $path = $file->storeAs('private_uploads/pan_card', $filename);

            // Save only the filename in the database (no directory path)
            $document = new Document;
            $document->user_id = Auth::id();
            $document->pan_card_image = $filename;  // Store only the image name in the database
            $document->save();

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
        return view('pan_data_review');
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
}
