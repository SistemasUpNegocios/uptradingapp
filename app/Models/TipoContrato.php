<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    use HasFactory;

    protected $table = "tipo_contrato";
    public $timestamps = false;

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }

    public function contrato()
    {
        return $this->hasMany(Contrato::class);
    }
}
