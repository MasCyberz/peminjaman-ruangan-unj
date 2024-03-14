<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('numero', 10);

        $users = User::paginate($limit);
        return view('admin.users.management-user', ['Users' => $users, 'numero' => $request->input('numero')]);
    }

    public function create(){
        $users = User::with('relasiRoles')->get();
        return view('admin.users.management-user-create', ['Users' => $users]);
    }

    public function store(Request $request){
        $createUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id
        ]);
        return redirect()->route('management-users')->with('success', 'Data user berhasil ditambahkan');
        // dd($request->all());
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('admin.users.management-user-edit', ['User' => $user]);
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id
        ]);
        return redirect()->route('management-users')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('management-users')->with('success', 'Data user berhasil dihapus');
    }
}
