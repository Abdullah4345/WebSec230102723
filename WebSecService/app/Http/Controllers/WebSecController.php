<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebSecController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'password'     => 'required|string|min:6'
        ]);

        // Build a success message (in a real app, you might store the user instead)
        $message = "Registration successful for {$validated['name']} with email {$validated['email']}.";

        // Redirect back to the registration page with a flash message.
        return redirect('/register')->with('message', $message);
    }
    public function login(Request $request)
    {
        // Validate the incoming request data.
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in.
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks.
            $request->session()->regenerate();

            // Redirect to the intended page (or default to '/dashboard').
            return redirect()->intended('/dashboard');
        }

        // If login fails, redirect back with an error message.
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
