<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lottery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function lottery()
    {
        $lotteries = Lottery::paginate(10);
        return view('layouts.dashboard-lottery', compact('lotteries'));  
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);  
        return view('layouts.dashboard-users', compact('users'));
    }
}
