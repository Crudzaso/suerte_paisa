<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $lotteries = Lottery::paginate(5);
            $users = User::paginate(10);
            
            return view('dashboard', compact('lotteries', 'users'));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
