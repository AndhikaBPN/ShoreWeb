<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return redirect()->back()->with('alert', 'Invalid credentials');
        }
    }

    public function register(Request $req){
        $req->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json(["status"=>["success"]], 200);
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Replace 'login' with the route name for your login page
    }
}