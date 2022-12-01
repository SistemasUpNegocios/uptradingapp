<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folio');
            $table->string('operador', 75);
            $table->string('operador_ine', 20);
            $table->string('lugar_firma', 30);
            $table->string('periodo', 30);
            $table->date('fecha');
            $table->date('fecha_renovacion');
            $table->date('fecha_pago');
            $table->date('fecha_limite');
            $table->timestamp('fecha_carga');
            $table->string('contrato', 20)->unique();
            $table->unsignedBigInteger('ps_id');
            $table->foreign('ps_id')->references('id')->on('ps')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('cliente')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipo_contrato')->onUpdate('cascade')->onDelete('cascade');
            $table->double('porcentaje');
            $table->double('inversion');
            $table->double('tipo_cambio')->default(20)->nullable();
            $table->double('inversion_us');
            $table->string('inversion_letra', 100);
            $table->string('inversion_letra_us', 100);
            $table->date('fecha_reintegro');
            $table->enum('status_reintegro', ['pendiente', 'pagado', 'cancelado'])->nullable();
            $table->string('memo_reintegro', 100)->nullable();
            $table->string('status', 30);
            $table->mediumtext('memo_status', 100)->nullable();
            $table->unsignedBigInteger('pendiente_id')->nullable();
            $table->foreign('pendiente_id')->references('id')->on('pendiente')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tipo_pago', 100)->nullable();
            $table->string('monto_pago', 100)->nullable();
            $table->string('comprobante_pago', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato');
    }
}