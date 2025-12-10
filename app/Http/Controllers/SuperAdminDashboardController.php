<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.superadmin');
    }

        public function blockedUsers()
    {
        // Ambil semua user yang diblokir
        $blockedUsers = User::where('is_blocked', true)->get();

        // Kirim ke view
        return view('dashboard.blocked-users', compact('blockedUsers'));
    }

    public function unblockUser(Request $request, User $user)
    {
        // Pastikan user benar-benar diblokir
        if ($user->is_blocked) {
            $user->update([
                'is_blocked' => false,
                'failed_attempts' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'User berhasil dibuka blokirnya.');
    }

    public function manageRoles()
    {
        // Ambil semua user
        $users = User::all();

        // Ambil semua role
        $roles = Role::all();

        return view('dashboard.manage-roles', compact('users', 'roles'));
    }

    /**
     * Update role user
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Hapus semua role sebelumnya dan assign role baru
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Role user berhasil diubah.');
    }
}
