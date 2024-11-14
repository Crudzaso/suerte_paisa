<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserRifaController extends Controller
{
    public function getLotteriesByUserId($userId)
    {
        // Encontrar el usuario por ID
        $user = User::findOrFail($userId);

        // Obtener las loterías asociadas al usuario
        $lotteries = $user->lotteries;

        // Retornar la respuesta en JSON
        return response()->json($lotteries);
    }
}
