<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('numero', 10);

        $users = User::paginate($limit);
        return view('admin.users.management-user', ['Users' => $users, 'numero' => $request->input('numero')]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.management-user-create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id'
        ], [
            'required' => ' :attribute harus diisi',
            'role_id.exists' => 'Role tidak ditemukan',
            'email.unique' => 'Email sudah terdaftar',

        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;

            if ($request->hasFile('foto_profil')) {
                $now = now();
                $tanggalJam = $now->format('dmY-His');
                $extension = $request->file('foto_profil')->getClientOriginalExtension();
                $namaBaru = $request->name . '-' . $tanggalJam . '.' . $extension;
                $request->file('foto_profil')->storeAs('foto_profile_akun', $namaBaru, 'public');
                $user->image = $namaBaru;
            }

            $user->save();
            return redirect()->route('management-users')->with('success', 'Data user berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan data user. Silakan coba lagi.']);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.management-user-edit', ['User' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id
        ]);
        return redirect()->route('management-users')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('management-users')->with('success', 'Data user berhasil dihapus');
    }
}
