<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descripcion', 'estatus', 'orden', // y otros campos que puedas tener
    ];

    protected $table = "notas";
    public $timestamps = false;
}