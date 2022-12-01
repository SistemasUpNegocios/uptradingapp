<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoPS extends Model
{
    use HasFactory;

    protected $table = "pago_ps";
    public $timestamps = false;
}
