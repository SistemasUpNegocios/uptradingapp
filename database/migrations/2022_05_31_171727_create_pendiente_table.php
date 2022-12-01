<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendiente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ps_id');
            $table->foreign('ps_id')->references('id')->on('ps')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('nombre', ['Pendiente', 'Hecho'])->default('Hecho');
            $table->string('memo_nombre', 255);
            $table->enum('introduccion', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_introduccion')->nullable();
            $table->timestamp('fecha_introduccion');
            $table->enum('intencion_inversion', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_intencion_inversion')->nullable();
            $table->timestamp('fecha_intencion_inversion');
            $table->enum('formulario', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_formulario')->nullable();
            $table->timestamp('fecha_formulario');
            $table->enum('videoconferencia', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_videoconferencia')->nullable();
            $table->timestamp('fecha_videoconferencia');
            $table->enum('apertura', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_apertura')->nullable();
            $table->timestamp('fecha_apertura');
            $table->enum('instrucciones_bancarias', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_instrucciones_bancarias')->nullable();
            $table->timestamp('fecha_instrucciones_bancarias');
            $table->enum('transferencia', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_transferencia')->nullable();
            $table->timestamp('fecha_transferencia');
            $table->enum('contrato', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_contrato')->nullable();
            $table->timestamp('fecha_contrato');
            $table->enum('conexion_mampool', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_conexion_mampool')->nullable();
            $table->timestamp('fecha_conexion_mampool');
            $table->enum('tarjeta_swissquote', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_tarjeta_swissquote')->nullable();
            $table->timestamp('fecha_tarjeta_swissquote');
            $table->enum('tarjeta_uptrading', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_tarjeta_uptrading')->nullable();
            $table->timestamp('fecha_tarjeta_uptrading');
            $table->enum('primer_pago', ['Pendiente', 'Hecho'])->default('Pendiente');
            $table->mediumtext('memo_primer_pago')->nullable();
            $table->timestamp('fecha_primer_pago');
            $table->timestamp('ultima_modificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendiente');
    }
}