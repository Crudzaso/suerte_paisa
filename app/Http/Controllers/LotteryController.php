<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Http\Requests\LotteryCreateFormRequest;
use App\Http\Requests\LotteryUpdateFormRequest;
use App\Events\LotteryCreated;
use App\Events\LotteryUpdated;
use App\Events\LotteryDeleted;
use App\Events\ErrorOccurred;

class LotteryController extends Controller
{
    public function index()
    {
        // Pagina las loterías y las pasa a la vista
        $loterias = Lottery::paginate(10);
        return view('layouts.dashboard-lottery', compact('loterias'));
    }

    public function create()
    {
        // Retorna la vista para crear una nueva lotería
        return view('layouts.dashboard-lottery');
    }

    public function store(LotteryCreateFormRequest $request)
    {
        try {
            // Crea una nueva lotería con los datos validados
            $lottery = Lottery::create($request->validated());
            event(new LotteryCreated($lottery));  // Dispara evento de creación
            return redirect()->route('loterias.index')->with('success', 'Lotería creada exitosamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al crear la lotería', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al crear la lotería.');
        }
    }

    public function show($id)
    {
        try {
            // Encuentra una lotería por ID y la pasa a la vista
            $lottery = Lottery::findOrFail($id);
            return view('layouts.dashboard-lottery', compact('lottery'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método show', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Lotería no encontrada.');
        }
    }

    public function edit($id)
    {
        try {
            // Encuentra la lotería por ID para editarla
            $lottery = Lottery::findOrFail($id);
            return view('layouts.dashboard-lottery', compact('lottery'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método edit', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al cargar la lotería.');
        }
    }

    public function update(LotteryUpdateFormRequest $request, $id)
    {
        try {
            // Encuentra la lotería por ID y actualízala
            $lottery = Lottery::findOrFail($id);
            $lottery->update($request->validated());
            event(new LotteryUpdated($lottery));  // Dispara evento de actualización
            return redirect()->route('loterias.index')->with('success', 'Lotería actualizada correctamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al actualizar la lotería', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al actualizar la lotería.');
        }
    }

    public function destroy($id)
    {
        try {
            // Encuentra y elimina la lotería
            $lottery = Lottery::findOrFail($id);
            $lottery->delete();
            event(new LotteryDeleted($lottery));  // Dispara evento de eliminación
            return redirect()->route('loterias.index')->with('success', 'Lotería eliminada correctamente.');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al eliminar la lotería', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al eliminar la lotería.');
        }
    }

    public function trashed()
    {
        try {
            $loterias = Lottery::onlyTrashed()->paginate(10);
            return view('layouts.dashboard-lottery', compact('loterias'));
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el método trashed', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al cargar las loterías eliminadas.');
        }
    }

    public function restore($id)
    {
        try {
            // Restaura una lotería eliminada
            $lottery = Lottery::withTrashed()->findOrFail($id);
            if ($lottery->trashed()) {
                $lottery->restore();
                return redirect()->route('loterias.trashed')->with('success', 'Lotería restaurada correctamente.');
            } else {
                return redirect()->route('loterias.trashed')->with('info', 'La lotería ya está restaurada.');
            }
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al restaurar la lotería', $e->getMessage()));
            return redirect()->route('loterias.index')->with('error', 'Error al restaurar la lotería.');
        }
    }
}
