<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reintegro extends Model
{
    use HasFactory;

    protected $table = "reintegro";
    public $timestamps = false;

    public function contratos()
    {
        return $this->hasMany(App\Models\Contrato::class);
    }

    
}
