<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\User;
use App\Http\Requests\LotteryCreateFormRequest;
use App\Http\Requests\LotteryUpdateFormRequest;
use Illuminate\Http\Request;
use App\Service\DiscordWebhookService;
use App\Events\LotteryCreated;
use App\Events\LotteryUpdated;
use App\Events\LotteryDeleted;

class LotteryController extends Controller
{
    protected $discordWebhookService;

    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhookService = $discordWebhookService;
    }

    /**
     * Mostrar listado de loterías
     */
    public function index()
    {
        try {
            $lotteries = Lottery::paginate(10); // Paginación de loterías
            return view('lotteries.index', compact('lotteries'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método index de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al cargar las loterías.');
        }
    }

    /**
     * Mostrar formulario para crear una nueva lotería
     */
    public function create()
    {
        return view('lotteries.create');
    }

    /**
     * Almacenar nueva lotería
     */
    public function store(LotteryCreateFormRequest $request)
    {
        try {
            $validatedData = $request->validated(); // Validación de los datos
            
            $lottery = Lottery::create($validatedData); // Crear la lotería en la base de datos
            
            event(new LotteryCreated($lottery)); // Evento cuando se crea una lotería

            return redirect()->route('lotteries.index')->with('success', 'Lotería creada correctamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método store de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al crear la lotería.');
        }
    }

    /**
     * Mostrar detalles de una lotería
     */
    public function show(string $id)
    {
        try {
            $lottery = Lottery::findOrFail($id); // Buscar la lotería por ID
            return view('lotteries.show', compact('lottery'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método show de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Lotería no encontrada.');
        }
    }

    /**
     * Mostrar formulario de edición de una lotería
     */
    public function edit(string $id)
    {
        try {
            $lottery = Lottery::findOrFail($id); // Buscar la lotería por ID
            return view('lotteries.edit', compact('lottery'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método edit de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al cargar la lotería para editar.');
        }
    }

    /**
     * Actualizar la lotería
     */
    public function update(LotteryUpdateFormRequest $request, string $id)
    {
        try {
            $lottery = Lottery::findOrFail($id); // Buscar la lotería por ID
            
            $validatedData = $request->validated(); // Validar los datos de la solicitud
            $lottery->update($validatedData); // Actualizar la lotería en la base de datos

            event(new LotteryUpdated($lottery)); // Evento cuando se actualiza la lotería

            return redirect()->route('lotteries.index')->with('success', 'Lotería actualizada correctamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método update de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al actualizar la lotería.');
        }
    }

    /**
     * Eliminar la lotería
     */
    public function destroy(string $id)
    {
        try {
            $lottery = Lottery::findOrFail($id); // Buscar la lotería por ID
            $lottery->delete(); // Eliminar la lotería (soft delete)

            event(new LotteryDeleted($lottery)); // Evento cuando se elimina una lotería

            return redirect()->route('lotteries.index')->with('success', 'Lotería eliminada correctamente.');
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método destroy de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al eliminar la lotería.');
        }
    }

    /**
     * Mostrar loterías eliminadas
     */
    public function trashed()
    {
        try {
            $lotteries = Lottery::onlyTrashed()->paginate(10); // Obtener loterías eliminadas

            if ($lotteries->isEmpty()) {
                return redirect()->route('lotteries.index')->with('info', 'No hay loterías eliminadas.');
            }

            return view('lotteries.trashed', compact('lotteries'));
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método trashed de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.index')->with('error', 'Error al cargar las loterías eliminadas.');
        }
    }

    /**
     * Restaurar una lotería eliminada
     */
    public function restore(string $id)
    {
        try {
            $lottery = Lottery::withTrashed()->findOrFail($id); 

            if ($lottery->trashed()) {
                $lottery->restore(); // Restaurar lotería
                return redirect()->route('lotteries.trashed')->with('success', 'Lotería restaurada correctamente.');
            } else {
                return redirect()->route('lotteries.trashed')->with('info', 'La lotería no está eliminada.');
            }
        } catch (\Exception $e) {
            $this->discordWebhookService->sendErrorToDiscord("Error en el método restore de LotteryController: " . $e->getMessage());
            return redirect()->route('lotteries.trashed')->with('error', 'Error al restaurar la lotería.');
        }
    }
}
