<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntencionInversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intencion_inversion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->unsignedBigInteger('telefono');
            $table->string('email', 100);
            $table->unsignedBigInteger('inversion_mxn');
            $table->unsignedBigInteger('inversion_usd');
            $table->unsignedBigInteger('tipo_cambio');
            $table->date('fecha_inicio');
            $table->date('fecha_renovacion');
            $table->date('fecha_pago');
            $table->string('tipo_1', 128);
            $table->double('porcentaje_tipo_1');
            $table->double('porcentaje_inversion_1');
            $table->string('tipo_2', 128)->nullable();
            $table->double('porcentaje_tipo_2')->nullable();
            $table->double('porcentaje_inversion_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intencion_inversion');
    }
}