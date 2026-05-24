<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // 1. TAMPILKAN DATA PETUGAS
    public function index() {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    // 2. TAMBAH DATA PETUGAS
    public function store(Request $request) {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email', 
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas', 
        ]);

        return redirect()->back()->with('success', 'Petugas berhasil ditambah!');
    }

    // 3. EDIT DATA PETUGAS
    public function update(Request $request, $id) {
        $petugas = User::findOrFail($id);

        // Validasi (Email unik, tapi kecualikan ID dia sendiri)
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id, 
            'password' => 'nullable|min:6', // Password boleh kosong kalau gak mau ganti
        ]);

        // Siapkan data yang mau diubah
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Kalau form password diisi, baru kita enkripsi dan masukkan ke data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->back()->with('success', 'Data Petugas berhasil diupdate!');
    }

    // 4. HAPUS DATA PETUGAS
    public function destroy($id) {
        User::destroy($id);
        return redirect()->back()->with('success', 'Petugas berhasil dihapus!');
    }
}