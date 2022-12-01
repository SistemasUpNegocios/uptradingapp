<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulario', function (Blueprint $table) {
            $table->id();
            $table->string('codigoCliente', 20)->nullable();
            $table->string('nombre', 40);
            $table->string('apellido_p', 40);
            $table->string('apellido_m',  40);
            $table->string('estado_civil',  20);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nacionalidad', 30)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->string('colonia', 30)->nullable();
            $table->unsignedInteger('cp')->nullable();
            $table->string('ciudad', 30)->nullable();
            $table->string('estado', 30)->nullable();
            $table->string('pais', 50)->nullable();
            $table->string('celular', 11)->nullable();
            $table->string('correo_personal', 70)->nullable();
            $table->string('correo_institucional', 100)->nullable();
            $table->string('fuera_mexico', 5)->nullable();
            $table->string('situacion_laboral', 20)->nullable();
            $table->mediumtext('nombre_direccion')->nullable();
            $table->string('giro_empresa', 20)->nullable();
            $table->mediumtext('puesto')->nullable();
            $table->string('sector_empresa', 20)->nullable();
            $table->unsignedInteger('personas_cargo')->nullable();
            $table->double('porcentaje_acciones')->nullable();
            $table->string('monto_anio', 50)->nullable();
            $table->mediumtext('pagina_web')->nullable();
            $table->mediumtext('ultimo_empleo')->nullable();
            $table->mediumtext('ultimo_empleador')->nullable();
            $table->mediumtext('status_anterior')->nullable();
            $table->double('monto_mensual_jubilacion')->nullable();
            $table->string('escuela_universidad', 100)->nullable();
            $table->string('campo_facultad', 100)->nullable();
            $table->longtext('especificacion_trabajo')->nullable();
            $table->string('funcion_publica', 3)->nullable();
            $table->longtext('descripcion_funcion_publica')->nullable();
            $table->string('residencia', 50)->nullable();
            $table->string('rfc', 30)->nullable();
            $table->double('deposito_inicial')->nullable();
            $table->string('origen_dinero', 100)->nullable();
            $table->string('ps_nombre', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulario');
    }
}