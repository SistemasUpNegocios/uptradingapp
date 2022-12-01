<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('hora_fecha')->useCurrent = true;
            $table->enum('tipo_accion', ['Eliminación', 'Actualización', 'Inserción']);
            $table->string('tabla', 255);
            $table->unsignedBigInteger('id_tabla')->nullable();
            $table->unsignedBigInteger('bitacora_id');
            $table->foreign('bitacora_id')->references('id')->on('bitacora_acceso')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
