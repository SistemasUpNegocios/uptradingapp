<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CumpleEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->subject("Feliz Cumpleaños $nombre");
        $this->from('mensajes@uptradingexperts.com', 'Familia Up Trading Experts');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.cumpleanios');
    }
}