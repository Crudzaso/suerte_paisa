<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
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

    //method to buy a lottery

    public function buyLottery($userId, $lotteryId){
        $user = User::findOrFail($userId);
        $lottery = Lottery::findOrFail($lotteryId);

        if($lottery){
            $user->lotteries()->detach($lotteryId);
            return redirect()->route('home.home-user', $userId)->with('message', 'La lotería ha sido comprada con éxito.');
        }
        return redirect()->route('home.home-user', $userId)->with('error', 'Error al comprar la lotería.');
    }
}
