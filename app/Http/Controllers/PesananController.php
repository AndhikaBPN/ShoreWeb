<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    // Show the pesanan form
    public function showPesananForm()
    {
        return view('pesanan'); 
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
            'treatment' => 'required|string',
            'jumlahsepatu' => 'required|numeric|min:1',
        ]);

        // Calculate the price based on the treatment and number of shoes
        $harga = 0;
        if ($request->input('treatment') === 'regular') {
            $harga = 30000 * $request->input('jumlahsepatu');
        } elseif ($request->input('treatment') === 'express') {
            $harga = 50000 * $request->input('jumlahsepatu');
        }

        // Create a new Pesanan instance and save it to the database
        Pesanan::create([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('treatment'),
            'jumlahsepatu' => $request->input('jumlahsepatu'),
            'harga' => $harga,
        ]);

        // Store the data in the session
        session()->put('nama', $request->input('nama'));
        session()->put('treatment', $request->input('treatment'));
        session()->put('jumlahsepatu', $request->input('jumlahsepatu'));
        session()->put('harga', $harga);

        // Redirect to the hasil route
        return redirect()->route('pesan-hasil')->with('success', 'Terima kasih sudah order!');
    }

    public function hasil()
    {
        // Retrieve the data from the session
        $nama = session('nama');
        $treatment = session('treatment');
        $jumlahsepatu = session('jumlahsepatu');
        $harga = session('harga');

        // Return the view and pass the data to it
        return view('hasil', compact('nama', 'treatment', 'jumlahsepatu', 'harga'));
    }

    public function download(Request $request)
    {
        // Generate the PDF
        $nama = $request->input('nama'); // Define the $nama variable
        $jumlahsepatu = $request->input('jumlahsepatu'); // Define the $nama variable
        $jenis = $request->input('treatment'); // Define the $nama variable
        $harga = $request->input('harga');

        // Set the PDF size to A7
        $pdf = PDF::loadView('pdf.struk', compact('nama', 'harga', 'jenis', 'jumlahsepatu'))->setPaper('a7', 'portrait');


        // Remove the data from the session to avoid showing it again upon page refresh
        session()->forget(['nama', 'treatment', 'jumlahsepatu', 'harga']);

        // Download the PDF to the user's browser
        return $pdf->download('struk.pdf');
    }
}
