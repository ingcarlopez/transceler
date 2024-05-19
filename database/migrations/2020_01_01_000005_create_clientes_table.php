<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_clientes', function (Blueprint $table) {
            $table->increments('idcliente');
            $table->integer('idcuenta')->index('tb_clientes_tb_cuentas_idcuenta_index');
            $table->string('cliente', 250);
            $table->string('identificacion', 20);
            $table->smallInteger('dv')->nullable();
            $table->smallInteger('idtipoid')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('idciudad', 50)->nullable();
            $table->string('zipcode', 25)->nullable();
            $table->jsonb('datos')->default('{"tipopersona": "Persona Natural"}');
            $table->timestamp('created_at');
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_clientes');
    }
};
