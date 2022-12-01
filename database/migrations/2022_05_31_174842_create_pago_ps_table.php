<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoPsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_ps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')->on('contrato')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('serie');
            $table->date('fecha_pago');
            $table->date('fecha_limite')->nullable();
            $table->date('fecha_pagado')->nullable();
            $table->double('pago')->nullable();
            $table->enum('status', ['Pendiente', 'Pagado', 'Cancelado'])->default("Pendiente");
            $table->string('memo', 35)->nullable();
            $table->enum('tipo_pago', ['Pendiente', 'Efectivo', 'Transferencia Swissquote', 'Transferencia MX'])->nullable()->default("Pendiente");
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
        Schema::dropIfExists('pago_ps');
    }
}