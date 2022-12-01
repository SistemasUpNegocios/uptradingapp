<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoPSConvenio extends Model
{
    use HasFactory;

    protected $table = "pago_ps_convenio";
    public $timestamps = false;
}
