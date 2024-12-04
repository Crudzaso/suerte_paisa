<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(10);

            $user = Auth::User();

            switch ($user->roles->first()->name) {
                case 'admin':
                    $lotteries = Lottery::paginate(5);
                    break;
                    
                case 'organizador':
                    $lotteries = $user->lotteries()->paginate(5);
                    break;

                default:
                    # code...
                    break;
            }
            
            return view('dashboard', compact('lotteries', 'users'));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
