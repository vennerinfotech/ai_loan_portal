<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSettingController extends Controller
{
    public function user_setting()
    {
        $user = Auth::user();

        $nameParts = explode(' ', $user->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        return view('user_setting', compact('user', 'firstName', 'lastName'));
    }

    public function showChangeMpin()
    {
        return view('change_mpin');
    }

    public function updateMpin(Request $request)
    {
        $request->validate([
            'old_mpin' => 'required|array|size:6',
            'old_mpin.*' => 'required|numeric|digits:1',
            'mpin' => 'required|array|size:6',
            'mpin.*' => 'required|numeric|digits:1',
            'cmpin' => 'required|array|size:6',
            'cmpin.*' => 'required|numeric|digits:1',
        ]);

        $oldMpin = implode('', $request->input('old_mpin'));
        $newMpin = implode('', $request->input('mpin'));
        $confirmMpin = implode('', $request->input('cmpin'));

        if ($newMpin !== $confirmMpin) {
            return back()->withErrors(['cmpin' => 'New MPIN and Confirm MPIN do not match.']);
        }

        $user = Auth::user();
        $customer = $user->customer;  // Assuming relation exists, or find by phone

        if (!$customer) {
            $customer = \App\Models\Customer::where('phone', '=', $user->phone)->first();
        }

        if (!$customer) {
            return back()->withErrors(['error' => 'Customer record not found.']);
        }

        // Verify Old MPIN
        // Check if old MPIN matches
        if (!Hash::check($oldMpin, $customer->m_pin)) {
            return back()->withErrors(['old_mpin' => 'The Old MPIN is incorrect.']);
        }

        // Update MPIN
        $customer->m_pin = Hash::make($newMpin);
        $customer->save();

        // Also update User table if needed (storing plain or hashed?)
        // Based on RegisterController logic: $user->m_pin = $mpin; (Plain?)
        // Let's stick to what RegisterController does.
        $user->m_pin = $newMpin;  // Storing plain as per RegisterController logic seen previously
        $user->save();

        return redirect()->route('user_setting')->with('success', 'Security Settings updated successfully');
    }

    public function updatePersonalInfo(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $customer = $user->customer ?? \App\Models\Customer::where('phone', '=', $user->phone)->first();

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image))) {
                unlink(storage_path('app/public/' . $user->profile_image));
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;

            if ($customer) {
                $customer->profile_image = $imagePath;
            }
        }

        // Handle Name Update
        $fullName = trim($request->first_name . ' ' . $request->last_name);
        $user->name = $fullName;

        if ($customer) {
            $customer->name = $fullName;
        }

        // Save User
        $user->save();

        // Save Customer
        if ($customer) {
            $customer->save();
        }

        return back()->with('success', 'Personal Information updated successfully');
    }
}
