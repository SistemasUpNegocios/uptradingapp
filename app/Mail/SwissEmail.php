<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SwissEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $nombreDescarga;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $nombreDescarga)
    {
        $this->nombre = $nombre;
        $this->subject("DOCUMENTO LPOA PARA CUENTA MAM");
        $this->from('clientes@uptradingexperts.com', 'Clientes UP Trading Experts');
        $this->attach(public_path() . '/documentos/clientes/' . $nombreDescarga);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.swiss');
    }
}