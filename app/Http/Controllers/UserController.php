<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        // Ambil data user, urutkan terbaru, dan paginate
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form create.
     */
    public function create()
    {
        // Kita kirim object User kosong agar _form.blade.php tidak error saat cek value
        $user = new User;

        return view('users.create', compact('user'));
    }

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:pengguna'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:Pegawai,Pimpinan'],
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:pengguna,username,'.$user->id],
            'role' => ['required', 'in:Pegawai,Pimpinan'],
        ];

        // Password opsional saat update (kalau kosong berarti tidak diganti)
        if ($request->filled('password')) {
            $rules['password'] = ['min:6'];
        }

        $request->validate($rules);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
