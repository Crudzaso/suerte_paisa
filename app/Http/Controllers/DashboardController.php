<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lottery;

class DashboardController extends Controller
{

    public function index()
    {
        return redirect()->route('dashboard.lottery');
    }

    // Método para mostrar las loterías
    public function lottery()
    {
        $lotteries = Lottery::paginate(10);
        return view('layouts.dashboard-lottery', compact('lotteries'));
    }

    // Método para mostrar los usuarios
    public function users()
    {
        $users = User::with('roles')->paginate(10);  
        return view('layouts.dashboard-users', compact('users'));
    }
}

