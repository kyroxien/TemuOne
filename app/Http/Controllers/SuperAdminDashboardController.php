<?php

namespace App\Http\Controllers;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.superadmin');
    }
}
