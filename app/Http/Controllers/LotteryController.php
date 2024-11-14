<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    // Obtener todas las loterías
    public function index()
    {
        try {
            $lotteries = Lottery::all();
            return view('home.home-main', compact('lotteries'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las loterías', 'message' => $e->getMessage()], 500);
        }
    }

    // Crear una nueva lotería
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'string|nullable',
                'banner_url' => 'string|nullable',
                'logo_url' => 'string|nullable',
                'date_play' => 'required|date',
                'result' => 'string|nullable',
                'prize' => 'string|nullable',
                'price' => 'required|numeric'
            ]);

            $lottery = Lottery::create($validatedData);
            return response()->json($lottery, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la lotería', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
{
    try {
        $lottery = Lottery::findOrFail($id);
        return response()->json($lottery, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Lotería no encontrada', 'message' => $e->getMessage()], 404);
    }
}


    // Actualizar una lotería
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'string|nullable',
                'description' => 'string|nullable',
                'banner_url' => 'string|nullable',
                'logo_url' => 'string|nullable',
                'date_play' => 'date|nullable',
                'result' => 'string|nullable',
                'prize' => 'string|nullable',
                'price' => 'numeric|nullable'
            ]);

            $lottery = Lottery::findOrFail($id);
            $lottery->update($validatedData);

            return response()->json($lottery, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la lotería', 'message' => $e->getMessage()], 500);
        }
    }

    // Eliminar una lotería (soft delete)
    public function destroy($id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
            $lottery->delete();

            return response()->json(['message' => 'Lotería eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la lotería', 'message' => $e->getMessage()], 500);
        }
    }

    // Crear una compra de número (relación usuario-lotería)
    public function purchaseNumber(Request $request, $lotteryId)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $lottery = Lottery::findOrFail($lotteryId);
            $user = User::findOrFail($validatedData['user_id']);

            // Crear la relación en la tabla intermedia
            $user->lotteries()->attach($lottery->id);

            return response()->json(['message' => 'Número comprado correctamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al comprar el número', 'message' => $e->getMessage()], 500);
        }
    }
}
