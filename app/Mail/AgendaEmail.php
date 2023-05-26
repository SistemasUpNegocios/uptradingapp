<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgendaEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $fecha;
    public $hora;
    public $asunto;
    public $descripcion;
    public $tipo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $fecha, $hora, $asunto, $descripcion, $tipo)
    {
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->asunto = $asunto;
        $this->descripcion = $descripcion;
        if($tipo == "nueva"){
            $this->subject("CITA AGENDADA");
        }else{
            $this->subject("CITA ACTUALIZADA");
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.agenda');
    }
}