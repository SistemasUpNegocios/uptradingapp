<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $fecha_inicio;
    public $fecha_fin;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
        $this->fecha_inicio = \Carbon\Carbon::now()->subDays(1)->formatLocalized('%d de %B de %Y');
        $this->fecha_fin = \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.backup')->subject("Backup de archivos y Base de Datos");
    }
}
