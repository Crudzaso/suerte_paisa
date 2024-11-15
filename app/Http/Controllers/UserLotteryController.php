<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function buyLottery(Request $request){
        try{
            
            $user = $request->user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión para comprar un número.');
            }
    
            $userId = $user->id; 
            $lotteryId = $request->input('lottery_id');

            $user = User::findOrFail($userId);
        $lottery = Lottery::findOrFail($lotteryId);

         // get the max number of lottery
         $maxNumber = $lottery->max_number;

        //Check if el numero is avalible
            do {
                $randomNumber = rand(1, $maxNumber);
                $numberExists = $lottery->users()->wherePivot('number', $randomNumber)->exists();
            } while ($numberExists);

             $user->lotteries()->attach($lotteryId, ['number' => $randomNumber]);
             $lotteries = Lottery::all();
             return redirect()->back()->with('success', 'Número comprado con éxito. Su número es: ' . $randomNumber);
             
        } catch(Exception $e){
            return redirect()->route('', $userId)->with('error', 'Error al comprar la lotería.');
        }
        
    }
}
