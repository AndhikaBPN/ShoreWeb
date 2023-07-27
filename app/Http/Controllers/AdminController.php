<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class AdminController extends Controller
{
    // Show all data of Pesanan model
    public function index()
    {
        // Fetch all data from the Pesanan model
        $pesananData = Pesanan::all();

        // Pass the data to the view and return it
        return view('admin', compact('pesananData'));
    }
}
