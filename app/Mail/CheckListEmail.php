<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckListEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $pendientes;
    public $fecha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pendientes, $fecha)
    {
        $this->pendientes = $pendientes;
        $this->fecha = $fecha;
        $this->subject("PENDIENTES DE CHECKLIST");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.checklist');
    }
}