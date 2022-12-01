<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvenioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenio', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 20);
            $table->double('monto');
            $table->string('monto_letra', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->double('capertura');
            $table->double('cmensual');
            $table->double('ctrimestral');
            $table->enum('status', ['Pendiente de activación', 'Activado', 'Finiquitado', 'Refrendado', 'Cancelado'])->nullable();
            $table->unsignedBigInteger('numerocuenta');
            $table->unsignedBigInteger('ps_id');
            $table->foreign('ps_id')->references('id')->on('ps')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('cliente')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('banco_id');
            $table->foreign('banco_id')->references('id')->on('banco')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenio');
    }
}
