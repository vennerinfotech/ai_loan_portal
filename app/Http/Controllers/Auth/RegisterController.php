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

        $customerId = Session::get('customer_id');
        $existingCustomer = $customerId ? Customer::find($customerId) : null;
        // Try to find the associated user (assuming email is consistent)
        $existingUser = $existingCustomer ? User::where('email', $existingCustomer->email)->first() : null;

        // Validate the registration form input
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'reference_code' => 'nullable|string|regex:/^[A-Z]{3}[0-9]{3}$/',
            ];

            if ($existingCustomer && $existingUser) {
                // Update mode: Ignore current IDs in uniqueness check
                // Note: We use $existingUser->id for users table check to be safe
                $rules['phone'] = 'required|string|regex:/^[0-9]{10}$/|unique:customers,phone,' . $existingCustomer->id . '|unique:users,phone,' . $existingUser->id;
                $rules['email'] = 'nullable|email|unique:customers,email,' . $existingCustomer->id . '|unique:users,email,' . $existingUser->id;
            } else {
                // Create mode: Standard checks
                $rules['phone'] = 'required|string|regex:/^[0-9]{10}$/|unique:customers,phone|unique:users,phone';
                $rules['email'] = 'nullable|email|unique:customers,email|unique:users,email';
            }

            $validated = $request->validate($rules);
            Log::info('Validated Data:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Failed:', $e->errors());

            return back()->withErrors($e->errors())->withInput($request->except('password'));
        }

        $cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $validated['phone']);
        Log::info('Cleaned Phone Number:', ['phone' => $cleanedPhoneNumber]);

        DB::beginTransaction();

        try {
            // Generate random OTP
            $otp = rand(100000, 999999);
            $otpExpiresAt = now()->addMinutes(2);  // OTP expiration time (2 minutes)

            if ($existingCustomer && $existingUser) {
                // Update existing records
                $existingCustomer->update([
                    'name' => $validated['name'],
                    'phone' => $cleanedPhoneNumber,
                    'email' => $validated['email'],
                    'reference_code' => $validated['reference_code'],
                    'otp' => $otp,
                    'otp_expires_at' => $otpExpiresAt,
                ]);

                $existingUser->update([
                    'name' => $validated['name'],
                    'phone' => $cleanedPhoneNumber,
                    'email' => $validated['email'],
                    'reference_code' => $validated['reference_code'],
                    'otp' => $otp,
                    'otp_expires_at' => $otpExpiresAt,
                ]);

                $customer = $existingCustomer;
                Log::info('Customer and User Updated:', ['id' => $customer->id]);
            } else {
                // Create new records
                $customer = Customer::create([
                    'name' => $validated['name'],
                    'phone' => $cleanedPhoneNumber,
                    'email' => $validated['email'],
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
                    'reference_code' => $validated['reference_code'],
                    'otp' => $otp,
                    'otp_expires_at' => $otpExpiresAt,
                    'password' => bcrypt('defaultpassword'),  // or generate a password
                ]);

                Log::info('User Created:', $user->toArray());
            }

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
            Log::error('Error during customer creation/update: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['error' => 'An error occurred while processing your request.'])->withInput();
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
        if (!$sessionOtp || Carbon::now()->greaterThan($otpExpiresAt)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => ['otp' => 'OTP has expired or is invalid. Please request a new one.']]);
            }

            return back()->withErrors(['error' => 'OTP has expired or is invalid. Please request a new one.']);
        }

        // Validate the OTP entered by the user
        $request->validate([
            'otp' => 'required|numeric|digits:6',  // Ensure OTP is a 6-digit number
        ]);

        $enteredOtp = $request->input('otp');

        // Compare entered OTP with the one in session
        if ($enteredOtp == $sessionOtp) {
            // OTP is valid, proceed with verification
            $customer = Customer::find(Session::get('customer_id'));

            // Clear the OTP from the session after successful verification
            Session::forget('otp');
            Session::forget('otp_expires_at');

            // For JSON requests (AJAX)
            if ($request->wantsJson()) {
                Session::flash('success', 'Your account has been successfully verified.');

                return response()->json(['success' => true, 'redirect_url' => route('mpin')]);  // Assuming next step is MPIN or Home
            }

            return redirect()->route('mpin')->with('success', 'Your account has been successfully verified.');
        } else {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => ['otp' => 'Invalid OTP. Please try again.']]);
            }

            return back()->withErrors(['error' => 'Invalid OTP. Please try again.']);
        }
    }

    /**
     * Show show_verify_otp resource.
     */
    public function show_verify_otp()
    {
        $customerId = Session::get('customer_id');
        $customer = Customer::find($customerId);
        $phone = $customer ? $customer->phone : 'N/A';
        $expiresAt = Session::get('otp_expires_at');

        return view('auth.verify_otp', compact('phone', 'expiresAt'));
    }

    public function resendOtp()
    {
        $customerId = Session::get('customer_id');
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'Session expired']);
        }

        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(2);

        Session::put('otp', $otp);
        Session::put('otp_expires_at', $otpExpiresAt);

        // Update DB
        $customer = Customer::find($customerId);
        if ($customer) {
            $customer->update(['otp' => $otp, 'otp_expires_at' => $otpExpiresAt]);
            // Also update user table if needed, as per store method
            $user = User::find($customerId);
            if ($user) {
                $user->update(['otp' => $otp, 'otp_expires_at' => $otpExpiresAt]);
            }
        }

        Log::info('OTP Resent:', ['otp' => $otp, 'expires_at' => $otpExpiresAt]);

        return response()->json([
            'success' => true,
            'expires_at' => $otpExpiresAt->toIso8601String(),
            'otp' => $otp,  // For dev mode display
            'message' => 'OTP Resent Successfully',
        ]);
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

        if (!$customer) {
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

    public function forgot_mpin()
    {
        return view('forgot_mpin');
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

    public function changeNumber()
    {
        $customerId = Session::get('customer_id');

        if ($customerId) {
            $customer = Customer::find($customerId);

            if ($customer) {
                // Capture data to pre-fill
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'reference_code' => $customer->reference_code,
                ];

                // Do not delete the record.
                // Just clear OTP related session data but keep customer_id to enable update in store()
                Session::forget(['otp', 'otp_expires_at']);

                // Redirect to register with old input
                return redirect()->route('register.create')->withInput($data);
            }
        }

        return redirect()->route('register.create');
    }

    // --- Forgot MPIN Logic ---

    // 1. Send OTP
    public function sendForgotMpinOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10|exists:customers,phone',
        ], [
            'phone.exists' => 'This mobile number is not registered.',
        ]);

        $customer = Customer::where('phone', $request->phone)->first();

        // Generate OTP
        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(2);

        // Update DB
        $customer->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt
        ]);

        // Keep relevant data in session
        Session::put('forgot_mpin_customer_id', $customer->id);
        Session::put('forgot_mpin_phone', $customer->phone);
        Session::put('forgot_mpin_otp', $otp);
        Session::put('forgot_mpin_otp_expires_at', $otpExpiresAt);

        Log::info('Forgot MPIN OTP Sent:', ['phone' => $customer->phone, 'otp' => $otp]);

        return redirect()->route('forgot_mpin.verify_otp');
    }

    // 2. Show Verify OTP Page
    public function showForgotMpinVerifyOtp()
    {
        $phone = Session::get('forgot_mpin_phone');
        $expiresAt = Session::get('forgot_mpin_otp_expires_at');

        if (!$phone) {
            return redirect()->route('forgot_mpin');
        }

        return view('auth.forgot_mpin_verify_otp', compact('phone', 'expiresAt'));
    }

    // 3. Verify OTP
    public function verifyForgotMpinOtp(Request $request)
    {
        $sessionOtp = Session::get('forgot_mpin_otp');
        $otpExpiresAt = Session::get('forgot_mpin_otp_expires_at');

        if (!$sessionOtp || Carbon::now()->greaterThan($otpExpiresAt)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => ['otp' => 'OTP has expired. Please request a new one.']]);
            }
            return back()->withErrors(['error' => 'OTP has expired. Please request a new one.']);
        }

        $request->validate(['otp' => 'required|numeric|digits:6']);

        if ($request->otp == $sessionOtp) {
            // Success
            Session::forget('forgot_mpin_otp');  // Clear OTP
            Session::put('forgot_mpin_verified', true);  // Mark as verified

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'redirect_url' => route('reset.mpin.view')]);
            }
            return redirect()->route('reset.mpin.view');
        } else {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => ['otp' => 'Invalid OTP.']]);
            }
            return back()->withErrors(['error' => 'Invalid OTP.']);
        }
    }

    // 4. Resend OTP
    public function resendForgotMpinOtp()
    {
        $customerId = Session::get('forgot_mpin_customer_id');
        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'User not found or session expired.']);
        }

        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(2);

        $customer->update([
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt
        ]);

        Session::put('forgot_mpin_otp', $otp);
        Session::put('forgot_mpin_otp_expires_at', $otpExpiresAt);

        return response()->json([
            'success' => true,
            'expires_at' => $otpExpiresAt->toIso8601String(),
            'otp' => $otp,
            'message' => 'OTP Resent Successfully'
        ]);
    }

    // 5. Show Reset MPIN Page
    public function showResetMpin()
    {
        if (!Session::get('forgot_mpin_verified')) {
            return redirect()->route('forgot_mpin');
        }
        return view('auth.reset_mpin');
    }

    // 6. Store New MPIN
    public function storeNewMpin(Request $request)
    {
        if (!Session::get('forgot_mpin_verified')) {
            return redirect()->route('forgot_mpin');
        }

        $request->validate([
            'mpin' => 'required|array|size:6',
            'mpin.*' => 'required|numeric|digits:1',
            'cmpin' => 'required|array|size:6',
            'cmpin.*' => 'required|numeric|digits:1',
        ]);

        $mpin = implode('', $request->input('mpin'));
        $confirmMpin = implode('', $request->input('cmpin'));

        if ($mpin !== $confirmMpin) {
            return redirect()->back()->withErrors(['cmpin' => 'The MPIN and Confirm MPIN do not match!']);
        }

        $customerId = Session::get('forgot_mpin_customer_id');
        $customer = Customer::find($customerId);

        if ($customer) {
            $customer->m_pin = Hash::make($mpin);
            $customer->save();

            // Also update user table if needed
            $user = User::where('phone', $customer->phone)->first();
            if ($user) {
                $user->m_pin = $mpin;  // Or hashed if user table stores hashed
                $user->save();
            }
        }

        // Cleanup Session
        Session::forget(['forgot_mpin_customer_id', 'forgot_mpin_phone', 'forgot_mpin_otp', 'forgot_mpin_otp_expires_at', 'forgot_mpin_verified']);

        return redirect()->route('login')->with('success', 'MPIN Reset Successfully. Please login.');
    }
}
