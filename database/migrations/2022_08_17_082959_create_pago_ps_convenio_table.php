<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoPsConvenioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_ps_convenio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convenio_id');
            $table->foreign('convenio_id')->references('id')->on('convenio')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('serie');
            $table->date('fecha_pago');
            $table->date('fecha_limite');
            $table->date('fecha_pagado')->nullable();
            $table->double('pago')->nullable();
            $table->enum('status', ['Pendiente', 'Pagado', 'Cancelado'])->default("Pendiente");
            $table->string('memo', 255)->nullable();
            $table->enum('tipo_pago', ['Pendiente', 'Efectivo', 'Transferencia Swissquote', 'Transferencia MX'])->default("Pendiente");
            $table->string('comprobante', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pago_ps_convenio');
    }
}