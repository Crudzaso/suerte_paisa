<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\User;
use App\Enums\LotteryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LotteryController extends Controller
{
    // Obtener todas las loterías
    public function index()
    {
        try {
            $lotteries = Lottery::all();
            return view('home.home-main', compact('lotteries'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error ver las loterias.');
        }
    }

    public function create()
    {
        try {
            return view('lotteries.save');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error al mostrar el formulario para crear una lotería. ');
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
                'price' => 'required|numeric',
            ]);

            $lottery = new Lottery($validatedData);
            $lottery->created_user = Auth::id();
            $lottery->status = LotteryStatus::COMENZADO;

            $lottery->save();
            
            return redirect()->route('dashboard')->with('Creada', 'Se creó una nueva lotería.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error al crear la lotería: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            dd("hola");
            $lottery = Lottery::findOrFail($id);

            return view("lotteries.show", compact("lottery"));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error ver una loteria.');
        }
    }

    public function edit($id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
            return view('lotteries.save', compact('lottery'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Lotería no encontrada para editar. ');
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

            return redirect()->route('dashboard')->with('Actualizada', 'Se creo una nueva loteria.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error en actualizar la loteria.');
        }
    }

    public function destroy($id)
    {
        try {
            $lottery = Lottery::findOrFail($id);
            $lottery->delete();

            return redirect()->route('dashboard')->with('Eliminada', 'Se elimino una loteria.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error eliminar la loteria.');
        }
    }

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
            return redirect()->route('dashboard')->with('error', 'Error al comprar un numero de loteria.');
        }
    }
}
