<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the staff users.
     */
    public function index()
    {
        $staffUsers = User::where('role', 'user')->get();

        return view('users.index', compact('staffUsers'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun pegawai berhasil dibuat!');
    }

    /**
     * Toggle the is_active status of the user.
     */
    public function toggleActive(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun pegawai berhasil $status.");
    }

    /**
     * Reset the user password to default.
     */
    public function resetPassword(User $user)
    {
        $defaultPassword = config('app.default_user_password', env('DEFAULT_USER_PASSWORD', 'BPS@Bontang2026!'));
        
        $user->update([
            'password' => Hash::make($defaultPassword)
        ]);

        return back()->with('success', "Password pegawai {$user->name} berhasil di-reset ke default.");
    }
}
