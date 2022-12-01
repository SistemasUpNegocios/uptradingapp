<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoEscaneado extends Model
{
    use HasFactory;

    protected $table = "contrato_escaneado";
    public $timestamps = false;
}
