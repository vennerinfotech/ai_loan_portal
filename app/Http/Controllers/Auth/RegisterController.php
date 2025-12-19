<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:customers,phone|unique:users,phone',
                'email' => 'required|email|unique:customers,email|unique:users,email',
                'pan_card_number' => 'nullable|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'reference_code' => 'nullable|string|regex:/^[A-Z]{3}[0-9]{3}$/',
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

            // Insert the same data into the 'users' table
            $user = User::create([
                'name' => $validated['name'],
                'phone' => $cleanedPhoneNumber,
                'email' => $validated['email'],
                'pan_card_number' => $validated['pan_card_number'],
                'reference_code' => $validated['reference_code'],
                'otp' => $otp,
                'otp_expires_at' => $otpExpiresAt,
                'password' => bcrypt('defaultpassword'), // or generate a password
            ]);

            Log::info('User Created:', $user->toArray());

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

    /**
     * Show show_verify_otp resource.
     */
    public function show_verify_otp()
    {
        return view('auth.verify_otp');
    }

    /**
     * Store the generated MPIN in the database.
     */
    // public function storeMPIN(Request $request)
    // {
    //     Log::info('storeMPIN:', $request->all());
    //     $validated = $request->validate([
    //         'mpin' => 'required|array|size:6',  // Validate that it's an array of size 6
    //         'mpin.*' => 'required|numeric|digits:1',  // Ensure each digit is numeric and 1 character long
    //         'cmpin' => 'required|array|size:6',  // Validate that it's an array of size 6
    //         'cmpin.*' => 'required|numeric|digits:1',  // Ensure each digit is numeric and 1 character long
    //     ]);

    //     // Combine the MPIN and Confirm MPIN arrays into strings
    //     $mpin = implode('', $request->input('mpin'));  // Convert the MPIN array to a string
    //     $confirmMpin = implode('', $request->input('cmpin'));  // Convert the Confirm MPIN array to a string

    //     // Ensure MPIN and Confirm MPIN match
    //     if ($mpin !== $confirmMpin) {
    //         return redirect()->back()->withErrors(['cmpin' => 'The MPIN and Confirm MPIN do not match!']);
    //     }

    //     // Hash the MPIN before saving it to the customers table
    //     $hashedMpin = Hash::make($mpin);

    //     // Retrieve the customer using the session ID
    //     $customer = Customer::find(Session::get('customer_id'));  // Get customer from session

    //     if (! $customer) {
    //         return redirect()->back()->withErrors(['customer' => 'Customer not found']);
    //     }

    //     // Store the hashed MPIN in the customers table
    //     $customer->m_pin = $hashedMpin;  // Store the hashed MPIN
    //     $customer->save();  // Save the customer record

    //     // Store the MPIN in the users table (if required)
    //     $user = User::find(Session::get('customer_id'));  // Find the corresponding user (adjust logic if needed)

    //     if ($user) {
    //         $user->m_pin = $mpin;  // Store the plain MPIN (in case you need to store it for user)
    //         $user->save();  // Save the user record
    //     } else {
    //         return redirect()->back()->withErrors(['user' => 'User not found']);
    //     }

    //     // Redirect to the dashboard or next step
    //     return redirect()->route('dashboard')->with('success', 'MPIN generated successfully!');
    // }

    public function store_mpin(Request $request)
    {
        Log::info('storeMPIN:', $request->all());

        // Validate the MPIN and Confirm MPIN
        $validated = $request->validate([
            'mpin' => 'required|array|size:6',
            'mpin.*' => 'required|numeric|digits:1',
            'cmpin' => 'required|array|size:6',
            'cmpin.*' => 'required|numeric|digits:1',
        ]);

        // Combine the MPIN and Confirm MPIN arrays into strings
        $mpin = implode('', $request->input('mpin'));
        $confirmMpin = implode('', $request->input('cmpin'));

        // Ensure MPIN and Confirm MPIN match
        if ($mpin !== $confirmMpin) {
            return redirect()->back()->withErrors(['cmpin' => 'The MPIN and Confirm MPIN do not match!']);
        }

        // Hash the MPIN before saving it to the customers table
        $hashedMpin = Hash::make($mpin);

        // Retrieve the customer using the session ID
        $customer = Customer::find(Session::get('customer_id'));

        if (! $customer) {
            return redirect()->back()->withErrors(['customer' => 'Customer not found']);
        }

        // Store the hashed MPIN in the customers table
        $customer->m_pin = $hashedMpin;
        $customer->save();

        // Store the MPIN in the users table (if required)
        $user = User::find(Session::get('customer_id'));

        if ($user) {
            $user->m_pin = $mpin;  // Store the plain MPIN (if you need to store it for user)
            $user->save();
        } else {
            return redirect()->back()->withErrors(['user' => 'User not found']);
        }

        // Redirect to the dashboard or next step
        return redirect()->route('dashboard')->with('success', 'MPIN generated successfully!');
    }

    /**
     * Show show_mpin resource.
     */
    public function show_mpin()
    {
        return view('mpin');
    }

    /**
     * Show Dashboard resource.
     */
    public function showDashboard()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the currently authenticated user
            $user = Auth::user();
            // dd($user);

            // Pass the user's name to the view
            return view('dashboard', ['userName' => $user->name]);
        }

        // If user is not authenticated, redirect to login page
        return redirect()->route('login');
    }



}
