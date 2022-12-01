<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clausula extends Model
{
    use HasFactory;

    protected $table = "clausula";
    public $timestamps = false;

    public function tipoContratos()
    {
        return $this->hasMany(App\Models\TipoContrato::class);
    }
}
