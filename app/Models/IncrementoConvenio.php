<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncrementoConvenio extends Model
{
    use HasFactory;

    protected $table = "incremento_convenio";
    public $timestamps = false;
}
