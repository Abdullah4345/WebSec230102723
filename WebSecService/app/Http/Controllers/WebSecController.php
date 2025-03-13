<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebSecController extends Controller
{
    private $csvFile = 'accounts.csv';

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

        // Save user to CSV
        $userData = [
            $validated['name'],
            $validated['email'],
            $hashedPassword
        ];

        $fp = fopen(storage_path($this->csvFile), 'a');
        fputcsv($fp, $userData);
        fclose($fp);

        return redirect('/register')->with('message', "Registration successful for {$validated['name']}.");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Read CSV and check credentials
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
        if (!file_exists(storage_path($this->csvFile))) {
            return false;
        }

        $fp = fopen(storage_path($this->csvFile), 'r');
        while (($data = fgetcsv($fp)) !== false) {
            if ($data[1] === $email) {
                fclose($fp);
                return true;
            }
        }
        fclose($fp);
        return false;
    }

    private function checkCredentials($email, $password)
    {
        $filepath = storage_path($this->csvFile);
        if (!file_exists($filepath)) {
            \Log::error('CSV file not found at: ' . $filepath);
            return false;
        }

        $fp = fopen($filepath, 'r');
        while (($data = fgetcsv($fp)) !== false) {
            \Log::info('Reading CSV row:', [
                'name' => $data[0],
                'email' => $data[1],
                'stored_hash' => $data[2]
            ]);

            if ($data[1] === $email) {
                $matches = Hash::check($password, $data[2]);
                \Log::info('Password check:', [
                    'email_matched' => true,
                    'password_matched' => $matches
                ]);
                fclose($fp);
                
                if ($matches) {
                    return [
                        'name' => $data[0],
                        'email' => $data[1]
                    ];
                }
                return false;
            }
        }
        fclose($fp);
        return false;
    }
}
