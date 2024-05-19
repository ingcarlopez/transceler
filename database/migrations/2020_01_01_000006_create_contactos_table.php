<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->increments('idcontacto');
            $table->integer('idcuenta')->index();
            $table->integer('idcliente')->nullable()->index();
            $table->string('nombres', 25);
            $table->string('apellidos', 25);
            $table->string('email', 50)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('idciudad', 50)->nullable();
            $table->string('zipcode', 25)->nullable();
            $table->jsonb('datos')->default('{"saludo": "Señor"}');
            $table->string('usucreado', 20);
            $table->timestamp('fchcreado');
            $table->string('usuactualizado', 20)->nullable();
            $table->timestamp('fchactualizado')->nullable();
            $table->string('usueliminado', 20)->nullable();
            $table->timestamp('fcheliminado')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactos');
    }
}
