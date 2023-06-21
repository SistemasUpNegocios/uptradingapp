<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiarioConvenio extends Model
{
    use HasFactory;

    protected $table = "beneficiario_convenio";
    public $timestamps = false;
}