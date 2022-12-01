<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = "contrato";
    public $timestamps = false;

    public function ps()
    {
        return $this->hasMany(App\Models\Ps::class);
    }

    public function clientes()
    {
        return $this->hasMany(App\Models\Cliente::class);
    }

    public function tipo_contrato()
    {
        return $this->belongsTo(TipoContrato::class, 'tipo_id');
    }

    public function modelos()
    {
        return $this->hasMany(App\Models\Modelo::class);
    }
}
