<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SessionSetting;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'check.admin']);
    }

    /**
     * Display the internal user's profile and settings.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('group', 'roles');

        $sessionTimeout = SessionSetting::getCurrentTimeout();
        $inputtedCount = method_exists($user, 'inputtedRegulations') ? $user->inputtedRegulations()->count() : 0;
        $authorisedCount = method_exists($user, 'authorisedRegulations') ? $user->authorisedRegulations()->count() : 0;

        return view('admin.profile', compact('user', 'sessionTimeout', 'inputtedCount', 'authorisedCount'));
    }

    /**
     * Update the internal user's basic profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
        ]);

        $user->name = $request->name;
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        $user->save();

        if (class_exists(LogActivity::class)) {
            LogActivity::addToLog('Internal user (' . $user->name . ') updated their profile details.');
        }

        return redirect()->back()->with('success', 'Profile details updated successfully.');
    }

    /**
     * Update the internal user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!.%*#?&]/',
            ],
            'password_confirmation' => 'required',
        ], [
            'password.regex' => 'Password must include uppercase, lowercase, numbers, and special characters.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password provided is incorrect.');
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'The new password cannot be the same as your current password.');
        }

        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();

        if (class_exists(LogActivity::class)) {
            LogActivity::addToLog('Internal user (' . $user->name . ') updated their password.');
        }

        return redirect()->back()->with('success', 'Your password has been changed successfully.');
    }
}

