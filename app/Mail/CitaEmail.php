<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CitaEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $fecha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $fecha)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->subject("Cambio de horario de cita");
        $this->from('mensajes@uptradingexperts.com', 'Up Trading Experts');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.cita');
    }
}
