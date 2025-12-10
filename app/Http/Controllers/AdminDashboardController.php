<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin');
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
}
