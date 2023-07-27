<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pesanan;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('login'); // Create a login view (login.blade.php) for the login form
    }

    // Process the login form
    public function processLogin(Request $request)
    {
        // Validate the form data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user using the default 'auth' guard
        if (Auth::attempt($request->only('username', 'password'))) {
            // Authentication successful

            // Fetch all data from the Pesanan model
            $pesananData = Pesanan::all();

            // Pass the data to the view and return it
            return view('admin', compact('pesananData'));
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Replace 'login' with the route name for your login page
    }
}