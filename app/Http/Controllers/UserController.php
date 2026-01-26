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
        $users = User::latest()
            ->filter(request()->all())
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form create.
     */
    public function create()
    {
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
            // UPDATE VALIDASI ROLE: Tambahkan Administrator dan Gudang
            'role' => ['required', 'in:Administrator,Pegawai,Gudang,Pimpinan'],
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
            // UPDATE VALIDASI ROLE DISINI JUGA
            'role' => ['required', 'in:Administrator,Pegawai,Gudang,Pimpinan'],
        ];

        // Password opsional saat update
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
        // Opsional: Cegah menghapus diri sendiri agar admin tidak terkunci
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
