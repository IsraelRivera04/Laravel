<?php

namespace App\Mail;

use App\Models\JUego;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificarReponerStock extends Mailable
{
    use Queueable, SerializesModels;

    public $producto;

    /**
     * Crear una nueva instancia de mensaje.
     *
     * @return void
     */
    public function __construct($producto)
    {
        $this->producto = $producto;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function notificarReponerStock()
    {
    $correo = 'proyectofp45@gmail.com';
    Mail::to($correo)->send(new NotificarReponerStock());
    }
    public function build()
    {
        return $this->subject('¡Reponer stock de producto!')
                    ->view('emails.reponer_stock');
    }
}
