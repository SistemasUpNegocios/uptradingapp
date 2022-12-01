<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generado_por');
            $table->foreign('generado_por')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('asignado_a');
            $table->dateTime('fecha_generado');
            $table->dateTime('fecha_limite');
            $table->enum('departamento', ['Administración', 'Contaduría', 'Sistemas', 'Egresos', 'General']);
            $table->string('asunto', 128);
            $table->longText('descripcion');
            $table->enum('status', ['Abierto', 'En proceso', 'Cancelado', 'Terminado']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
