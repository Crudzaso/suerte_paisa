<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use MailerSend\Helpers\Builder\Variable;
use MailerSend\Helpers\Builder\Personalization;
use MailerSend\LaravelDriver\MailerSendTrait;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels, MailerSendTrait;

    protected $resetLink;

    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    public function build()
    {
        $to = $this->to[0]['address'] ?? null; // Obtener la dirección de correo de manera segura

        if (!$to) {
            throw new \Exception('No se encontró la dirección de correo electrónico.');
        }

        return $this->view('emails.password_reset')
            ->text('emails.test_text')
            ->mailersend(
                null, // ID de plantilla
                [
                    new Variable($to, ['name' => 'Usuario'])
                ],
                ['password_reset'], // Etiquetas
                null, // Cuarto parámetro como null
                [
                    new Personalization($to, [
                        'reset_link' => $this->resetLink
                    ])
                ]
            );
    }


}
