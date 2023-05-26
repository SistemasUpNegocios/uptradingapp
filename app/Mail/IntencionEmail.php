<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IntencionEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $fecha;
    public $nombreDescarga;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $fecha, $nombreDescarga)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->subject("INTENCIÓN DE INVERSIÓN");
        $this->from('mensajes@uptradingexperts.com', 'Administración UP Trading Experts');
        $this->attach(public_path() . '/documentos/intencion/' . $nombreDescarga);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.intencioninversion');
    }
}