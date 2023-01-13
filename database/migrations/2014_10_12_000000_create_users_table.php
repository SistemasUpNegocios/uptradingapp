<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
            $table->string('apellido_p', 30);
            $table->string('apellido_m', 30);
            $table->string('correo', 70)->unique();
            $table->string('password');
            $table->enum('privilegio', ['root','estandar','contabilidad','ps_diamond','ps_diamond','ps_gold','ps_silver','cliente','egresos','admin','procesos','cliente_ps_gold','cliente_ps_silver'])->default('admin');
            $table->string('foto_perfil', 255)->default('default.png');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}