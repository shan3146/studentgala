<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile edit page.
     */
    public function edit()
    {
        $user = Auth::user();

        return view(
            'user.profile.edit',
            compact('user')
        );
    }


    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Validate profile information
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'in:male,female,other',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update user
        |--------------------------------------------------------------------------
        */

        $user->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Return to dashboard profile section
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('user.dashboard')
            ->withFragment('profile')
            ->with(
                'success',
                'Your profile has been updated successfully.'
            );
    }
}

