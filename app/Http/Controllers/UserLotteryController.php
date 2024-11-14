<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserLotteryController extends Controller
{
     // get the lotteries associated with one user
    public function getLotteriesByUserId($userId)
    {
        $user = User::findOrFail($userId);
        $lotteries = $user->lotteries;

        return view("home.home-user", compact('user', 'lotteries'));
    }
}
