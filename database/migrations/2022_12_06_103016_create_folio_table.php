<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folio');
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('folio')->on('contrato')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('estatus', ['usado','cancelado'])->default('usado');
            $table->timestamp("fecha");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folio');
    }
}