<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroExitoso extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario; // Cambia a 'usuario'

    public function __construct($usuario)
    {
        $this->usuario = $usuario; // Cambia a 'usuario'
    }

    public function build()
    {
        return $this->view('emails.registro') 
                    ->subject('Registro Exitoso')
                    ->with(['usuario' => $this->usuario]); 
    }
}


