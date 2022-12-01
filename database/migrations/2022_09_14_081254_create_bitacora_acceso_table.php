<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_acceso', function (Blueprint $table) {
            $table->id();
            $table->string('direccion_ip', 15);
            $table->dateTime('fecha_entrada');
            $table->dateTime('fecha_salida');
            $table->string('dispositivo', 50);
            $table->string('sistema_operativo', 50);
            $table->string('navegador', 50);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora_acceso');
    }
}
