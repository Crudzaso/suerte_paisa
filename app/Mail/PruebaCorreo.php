<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PruebaCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $contenido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contenido)
    {
        $this->contenido = $contenido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prueba de Correo')
                    ->view('emails.prueba'); // Cambia a tu vista
    }
}
