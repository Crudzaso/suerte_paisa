<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

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
        try{
            $user = User::findOrFail($userId);
        $lottery = Lottery::findOrFail($lotteryId);

         // get the max number of lottery
         $maxNumber = $lottery->max_number;

        //Check if el numero is avalible
            do {
                // generate number between 0 and $maxNumber
                $randomNumber = rand(1, $maxNumber);
                $numberExists = $lottery->users()->wherePivot('number', $randomNumber)->exists();
            } while ($numberExists);
             $user->lotteries()->attach($lotteryId, ['number' => $randomNumber]);
        } catch(Exception $e){
            return redirect()->route('', $userId)->with('error', 'Error al comprar la lotería.');
        }
        
    }
}
