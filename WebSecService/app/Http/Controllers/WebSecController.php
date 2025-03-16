<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class WebSecController extends Controller
{
    private $jsonFile = 'accounts.json';

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        // Check if email already exists
        if ($this->emailExists($validated['email'])) {
            return back()->withErrors([
                'email' => 'This email is already registered.',
            ]);
        }

        // Hash the password
        $hashedPassword = Hash::make($validated['password']);

        // Save user to JSON
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $hashedPassword
        ];

        $users = $this->getUsers();
        $users[] = $userData;
        Storage::put($this->jsonFile, json_encode($users));

        return redirect('/register')->with('message', "Registration successful for {$validated['name']}.");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Read JSON and check credentials
        if ($userData = $this->checkCredentials($credentials['email'], $credentials['password'])) {
            $request->session()->regenerate();
            
            // Add debugging
            \Log::info('Login successful', [
                'user' => $userData,
                'session' => $request->session()->all()
            ]);
            
            // Store user data in session
            $request->session()->put('user', [
                'name' => $userData['name'],
                'email' => $userData['email']
            ]);
            
            // Changed the redirect to use url generation and ensure success message is passed
            return redirect()->to('/home')->with('success', 'Welcome back, ' . $userData['name']);
        }

        \Log::error('Login failed for email: ' . $credentials['email']);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        $name = session('user')['name'] ?? 'User';
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect('/')->with('success', "Goodbye, {$name}! You have been logged out successfully.");
    }

    private function emailExists($email)
    {
        $users = $this->getUsers();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    private function checkCredentials($email, $password)
    {
        $users = $this->getUsers();
        foreach ($users as $user) {
            \Log::info('Reading JSON user:', [
                'name' => $user['name'],
                'email' => $user['email'],
                'stored_hash' => $user['password']
            ]);

            if ($user['email'] === $email) {
                $matches = Hash::check($password, $user['password']);
                \Log::info('Password check:', [
                    'email_matched' => true,
                    'password_matched' => $matches
                ]);

                if ($matches) {
                    return [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
                return false;
            }
        }
        return false;
    }

    private function getUsers()
    {
        if (!Storage::exists($this->jsonFile)) {
            return [];
        }

        $json = Storage::get($this->jsonFile);
        return json_decode($json, true);
    }
}
