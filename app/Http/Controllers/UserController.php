<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles','branch')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();
        $roles = Role::pluck('name','name');
        return view('users.create', compact('branches','roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
            'branch_id' => 'nullable|exists:branches,id',
            'role'      => 'required|string|exists:roles,name', // pakai role name
        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'branch_id' => $data['branch_id'] ?? null,
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with('success','User created.');
    }

    public function edit(User $user)
    {
        $branches = Branch::all();
        $roles = Role::pluck('name','name');
        return view('users.edit', compact('user','branches','roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'password'  => 'nullable|min:6|confirmed',
            'branch_id' => 'nullable|exists:branches,id',
            'role'      => 'required|string',
        ]);

        $user->update([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'branch_id' => $data['branch_id'] ?? null,
        ]);

        if (!empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        $user->syncRoles([$data['role']]);

        return redirect()->route('users.index')->with('success','User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted.');
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'user_list.xlsx');
    }

    public function exportPdf()
    {
        $users = User::with('branch')->get(); // ambil dengan relasi lokasi
        $pdf = Pdf::loadView('exports.users-pdf', compact('users'));
        return $pdf->download('user_list.pdf');
    }
}
