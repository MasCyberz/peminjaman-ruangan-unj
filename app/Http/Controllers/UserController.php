<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'sometimes|min:5',
            'role_id' => 'nullable|exists:roles,id',
            'fotoprofil' => 'nullable|image|mimes:jpeg,png,jpg'
        ], [
            'password.min' => 'Password minimal 5 karakter',
            'role_id.exists' => 'Role tidak ditemukan',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Email harus valid',
            'fotoprofil.mimes' => 'File harus berupa jpeg, png, jpg',
            'fotoprofil.image' => 'File harus berupa gambar',
        ]);

        // try {
        //     $user = User::findOrFail($id);

        //     $user->name = $request->name;
        //     $user->email = $request->email;
        //     if ($request->filled('password')) {
        //         $user->password = Hash::make($request->password);
        //     }
        //     $user->role_id = $request->role_id;

            
        //     // Jika file foto profil dikirimkan, simpan dan update foto profil
        //     if ($request->hasFile('foto_profil')) {
        //         $now = now();
        //         $tanggalJam = $now->format('dmY-His');
        //         $extension = $request->file('foto_profil')->getClientOriginalExtension();
        //         $namaBaru = $request->name . '-' . $tanggalJam . '.' . $extension;
        //         $request->file('foto_profil')->storeAs('foto_profile_akun', $namaBaru, 'public');
        //         $user->image = $namaBaru;
        //     }

        //     $user->save();

        //     return redirect()->route('management-users')->with('success', 'Data user berhasil diperbarui');
        // } catch (\Exception $e) {
        //     return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data user. Silakan coba lagi.']);
        // }

        try {
            $user = User::findOrFail($id);
    
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->role_id = $request->role_id;
    
            // Hapus foto profil lama jika ada
            $fileToDelete = $user->image ;
            $path = 'public/foto_profile_akun/' . $fileToDelete;
    
            if ($request->hasFile('foto_profil')) {
                if ($fileToDelete) {
                    Storage::delete($path);
                }
    
                // Simpan foto profil baru
                $now = now();
                $tanggalJam = $now->format('dmY-His');
                $extension = $request->file('foto_profil')->getClientOriginalExtension();
                $namaBaru = $request->name . '-' . $tanggalJam . '.' . $extension;
                $request->file('foto_profil')->storeAs('foto_profile_akun', $namaBaru, 'public');
                $user->image = $namaBaru;
            }
    
            $user->save();
    
            return redirect()->route('management-users')->with('success', 'Data user berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data user. Silakan coba lagi.']);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('management-users')->with('success', 'Data user berhasil dihapus');
    }
}
