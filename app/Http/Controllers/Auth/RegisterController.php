<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Request Data Before Validation:', $request->all());

        // Validate the registration form input
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^\+?[0-9\s\(\)-]*$/|max:20|unique:customers,phone',
                'email' => 'required|email|unique:customers,email',
                'pan_card_number' => 'nullable|string|max:20',
                'reference_code' => 'nullable|string|max:10',
            ]);
            Log::info('Validated Data:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Failed:', $e->errors());

            return back()->withErrors($e->errors());
        }

        $cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $validated['phone']);
        Log::info('Cleaned Phone Number:', ['phone' => $cleanedPhoneNumber]);

        DB::beginTransaction();

        try {
            // Generate random OTP
            $otp = rand(100000, 999999);
            $otpExpiresAt = now()->addMinutes(2); // OTP expiration time (2 minutes)

            // Create the customer record
            $customer = Customer::create([
                'name' => $validated['name'],
                'phone' => $cleanedPhoneNumber,
                'email' => $validated['email'],
                'pan_card_number' => $validated['pan_card_number'],
                'reference_code' => $validated['reference_code'],
                'otp' => $otp,
                'otp_expires_at' => $otpExpiresAt,
            ]);

            Log::info('Customer Created:', $customer->toArray());

            // Commit the transaction
            DB::commit();
            Log::info('Transaction Committed');

            // Store the customer ID and OTP in session
            Session::put('customer_id', $customer->id);
            Session::put('otp', $otp);
            Session::put('otp_expires_at', $otpExpiresAt);

            Log::info('OTP Stored in session:', ['otp' => $otp]);

            return redirect()->route('verify.otp');  // Redirect to OTP verification route

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error during customer creation: '.$e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['error' => 'An error occurred while creating the customer.']);
        }
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
     * Validate the OTP entered by the user.
     */
    public function verifyOtp(Request $request)
    {
        // Retrieve OTP from session
        $sessionOtp = Session::get('otp');
        $otpExpiresAt = Session::get('otp_expires_at');

        // Check if OTP exists in session and if it has expired
        if (! $sessionOtp || Carbon::now()->greaterThan($otpExpiresAt)) {
            return back()->withErrors(['error' => 'OTP has expired or is invalid. Please request a new one.']);
        }

        // Validate the OTP entered by the user
        $request->validate([
            'otp' => 'required|numeric|digits:6', // Ensure OTP is a 6-digit number
        ]);

        $enteredOtp = $request->input('otp');

        // Compare entered OTP with the one in session
        if ($enteredOtp == $sessionOtp) {
            // OTP is valid, proceed with verification
            $customer = Customer::find(Session::get('customer_id'));

            // Optionally: Mark customer as verified or proceed to the next step
            // $customer->update(['verified' => true]);

            // Clear the OTP from the session after successful verification
            Session::forget('otp');
            Session::forget('otp_expires_at');

            return redirect()->route('home')->with('success', 'Your account has been successfully verified.');
        } else {
            return back()->withErrors(['error' => 'Invalid OTP. Please try again.']);
        }
    }
}
