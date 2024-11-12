<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;
use App\Events\UserLogin;
use App\Service\DiscordWebhookService;

class SendDiscordNotification
{
    protected $discordWebhook;

    // Colores predefinidos para cada tipo de acción
    private const COLOR_CREATED = 0x36ff00;
    private const COLOR_UPDATED = 0xfff700;
    private const COLOR_DELETED = 0xff2d00;
    private const COLOR_RESTORED = 0xde5e00;

    /**
     * Create the event listener.
     */
    public function __construct(DiscordWebhookService $discordWeebhookService)
    {
        $this->discordWebhook = $discordWeebhookService;
    }

    /**
     * Handle the event of create.
     */
    public function handleUserCreated(UserCreated $event): void
    {
        $this->sendNotification($event->user, 'creado', auth()->user(), self::COLOR_CREATED);
    }

    /**
     * Handle the event of update.
     */
    public function handleUserUpdated(UserUpdated $event): void
    {
        $this->sendNotification($event->user, 'actualizado', auth()->user(), self::COLOR_UPDATED);
    }

    /**
     * Handle the event of delete.
     */
    public function handleUserDeleted(UserDeleted $event): void
    {
        $this->sendNotification($event->user, 'eliminado', auth()->user(), self::COLOR_DELETED);
    }

    /**
     * Handle the event of restore.
     */
    public function handleUserRestore(UserRestore $event): void
    {
        $this->sendNotification($event->user, 'restaurado', auth()->user(), self::COLOR_RESTORED);
    }

    /**
     * Handle the event of restore.
     */
    public function handleUserLogin(UserLogin $event): void
    {
        $this->sendNotification($event->user, 'ingreso', auth()->user(), self::COLOR_CREATED);
    }

    protected function sendNotification($user, $action, $actor, $color)
    {
        try {
            $embed = [
                'title' => "🎉 Suerte paisa - Usuario {$action} 🎉",
                'color' => $color,
                'thumbnail' => [
                    //'url' => "https://suerte-paisa.crudzaso.com/public/assets/logos/logo.webp",
                    'url' => "https://i.postimg.cc/SKLLW24B/logo-suerte-paisa.webp",
                ],
                'fields' => [
                    [
                        'name' => '💼 Id de user',
                        'value' => "{$user->id}",
                        'inline' => true,
                    ],
                    [
                        'name' => '👤 Nombre Completo',
                        'value' => "{$user->names} {$user->lastnames}",
                        'inline' => true,
                    ],
                    [
                        'name' => '📧 Correo Electrónico',
                        'value' => $user->email,
                        'inline' => false,
                    ],
                    [
                        'name' => '🏠 Dirección',
                        'value' => $user->address ?? 'No proporcionado',
                        'inline' => false,
                    ],
                    [
                        'name' => '🛠️ Realizado por',
                        'value' => "{$actor->names} {$actor->lastnames} con el ID {$actor->id}",
                        'inline' => false,
                    ],
                ],
                'footer' => [
                    'text' => implode(" | ", [
                        '📍 Realizado en Suerte Paisa',
                        '🕒 Notificación realizada el ' . now()->format('d/m/y H:i')
                    ]),
                ],
                'timestamp' => now()->toIso8601String(),
                
                'author' => [
                    'name' => "👤 {$actor->names} {$actor->lastnames}",
                ],
            ];

            $this->discordWebhook->sendEmbed($embed);

        } catch (\Exception $e) {
            \Log::error("Error al enviar notificación de Discord: " . $e->getMessage());
        }
    }

    public function handle(ErrorOccurred $event): void
    {
        try {
            $embed = [
                'title' => "⚠️ Error en el sistema",
                'color' => self::ERROR_COLOR,
                'fields' => [
                    [
                        'name' => 'Mensaje de Error',
                        'value' => $event->message,
                        'inline' => false,
                    ],
                    [
                        'name' => 'Detalles del Error',
                        'value' => $event->errorDetails ?? 'No se proporcionaron detalles.',
                        'inline' => false,
                    ],
                ],
                'footer' => [
                    'text' => 'Notificación de error generada en Suerte Paisa',
                ],
                'timestamp' => now()->toIso8601String(),
            ];

            $this->discordWebhook->sendEmbed($embed);

        } catch (\Exception $e) {
            \Log::error("Error al enviar notificación de error a Discord: " . $e->getMessage());
        }
    }
}
