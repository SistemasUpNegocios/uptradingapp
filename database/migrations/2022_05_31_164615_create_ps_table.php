<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps', function (Blueprint $table) {
            $table->id();
            $table->string('codigoPS', 10);
            $table->string('nombre', 30);
            $table->string('apellido_p', 30);
            $table->string('apellido_m',  30);
            $table->date('fecha_nac');
            $table->string('nacionalidad', 30);
            $table->string('direccion', 50);
            $table->string('colonia', 30);
            $table->unsignedInteger('cp');
            $table->string('ciudad', 30);
            $table->string('estado', 30);
            $table->unsignedBigInteger('celular');
            $table->string('correo_personal', 70);
            $table->string('correo_institucional', 70);
            $table->unsignedBigInteger('ine')->nullable();;
            $table->string('pasaporte', 9)->nullable();;
            $table->date('vencimiento_pasaporte');
            $table->string('iban', 34)->nullable();
            $table->string('swift', 11)->nullable();
            $table->enum('tipo_ps', ['Encargado', 'Oficina']);
            $table->unsignedBigInteger('oficina_id');
            $table->foreign('oficina_id')->references('id')->on('oficina')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('encargado_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ps');
    }
}