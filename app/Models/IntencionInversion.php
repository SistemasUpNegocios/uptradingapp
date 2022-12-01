<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntencionInversion extends Model
{
    use HasFactory;

    protected $table = "intencion_inversion";
    public $timestamps = false;
}
