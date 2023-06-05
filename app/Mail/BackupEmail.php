<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $fecha;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
        $this->fecha = \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y');
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