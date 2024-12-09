<?php

namespace App\Http\Controllers;

use App\Events\LotteryPurchased;
use App\Models\Lottery;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserLotteryController extends Controller
{
    public function getLotteriesByUserId($userId)
    {
        $user = User::findOrFail($userId);
        $lotteries = $user->lotteries;

        return view("home.home-user", compact('user', 'lotteries'));
    }

    public function getNumbersLotteries($lotteryId)
    {
        $lottery = Lottery::findOrFail($lotteryId);

        
        $purchasedNumbers = $lottery->users()
            ->wherePivot('number', '!=', null)
            ->get()
            ->pluck('pivot.number')
            ->toArray();

        if (empty($purchasedNumbers)) {
            $purchasedNumbers = [];
        }

        //dd($purchasedNumbers);

        return view('home.home-lottery-details', compact('lottery', 'purchasedNumbers'));
    }



    public function buyLottery(Request $request)
    {
        try {
            $user = $request->user();
            $lotteryId = $request->input('lottery_id');
            $numbers = $request->input('numbers');

            if (empty($numbers)) {
                return redirect()->back()->with('error', 'Por favor, selecciona al menos un número.');
            }

            $lottery = Lottery::findOrFail($lotteryId);
            $errorNumbers = [];

            foreach ($numbers as $number) {
                if ($lottery->users()->wherePivot('number', $number)->exists()) {
                    $errorNumbers[] = $number;
                } else {
                    $user->lotteries()->attach($lotteryId, ['number' => $number]);
                }
            }

            if ($errorNumbers) {
                return redirect()->back()->with('error', 'Los números ya comprados: ' . implode(', ', $errorNumbers));
            }

            event(new LotteryPurchased($user, $lottery));
            return redirect()->back()->with('success', 'Números comprados con éxito.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al comprar los números de la lotería.');
        }
    }



}
