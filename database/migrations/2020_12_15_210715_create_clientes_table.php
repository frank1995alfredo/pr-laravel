<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('discapacidad_id');
            $table->integer('ciudad_id');
            $table->string('priNombre', 50);
            $table->string('segNombre', 50);
            $table->string('priApellido', 50);
            $table->string('segApellido', 50);
            $table->date('fechNacimiento')->nullable(); //admite valores nulos
            $table->string('numCedula', 11);
            $table->string('codigoCli', 10);
            $table->string('direccion', 60)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('telefono', 11)->nullable();
            $table->string('genero', 15);
            $table->boolean('estado')->default(true);
            $table->integer('nivelDiscapacidad');
            $table->timestamps();

            $table->foreign('discapacidad_id')->references('id')->on('discapacidades')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
