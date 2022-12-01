<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCliente extends Model
{
    use HasFactory;

    protected $table = "pago_cliente";
    public $timestamps = false;
}
