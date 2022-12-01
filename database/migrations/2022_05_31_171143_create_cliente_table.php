<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('codigoCliente', 20)->nullable()->unique();
            $table->string('nombre', 30);
            $table->string('apellido_p', 30);
            $table->string('apellido_m',  30);
            $table->date('fecha_nac')->nullable();
            $table->string('nacionalidad', 30)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->string('colonia', 30)->nullable();
            $table->unsignedInteger('cp')->nullable();
            $table->string('ciudad', 30)->nullable();
            $table->string('estado', 30)->nullable();
            $table->unsignedBigInteger('celular')->nullable();
            $table->string('correo_personal', 70)->nullable();
            $table->string('correo_institucional', 70)->nullable();
            $table->string('ine', 20)->nullable();
            $table->string('pasaporte', 9)->nullable();
            $table->date('vencimiento_pasaporte')->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('swift', 11)->nullable();
            $table->string('tarjeta', 5)->default('NO')->nullable();
            $table->string('ine_documento', 255)->nullable();
            $table->string('pasaporte_documento', 255)->nullable();
            $table->string('comprobante_domicilio', 255)->nullable();
            $table->string('lpoa_documento', 255)->nullable();
            $table->string('formulario_apertura', 255)->nullable();
            $table->string('formulario_riesgos', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}