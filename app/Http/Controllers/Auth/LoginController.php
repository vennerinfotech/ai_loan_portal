<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
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
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Handle the login request.
     */
    public function authenticate(Request $request)
    {
        // Validate email and MPIN fields
        $request->validate([
            'email' => 'required|email',
            'mpin' => 'required|digits:6',  // MPIN should be exactly 6 digits
        ]);

        // Find customer by email
        $customer = Customer::where('email', $request->email)->first();

        // Check if customer exists and the MPIN matches
        if ($customer && Hash::check($request->mpin, $customer->m_pin)) {
            // Log the user in
            Auth::loginUsingId($customer->id);

            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }

        // If authentication fails, return back with an error message
        return back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout()
    {
        Auth::logout();  // Log out the authenticated user

        return Redirect::route('login');  // Redirect to the login page after logout
    }
}
