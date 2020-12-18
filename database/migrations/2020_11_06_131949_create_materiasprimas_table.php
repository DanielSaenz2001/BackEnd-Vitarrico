<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasprimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias_primas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('stock');
            $table->text('descripcion');
            $table->string('unidad');
            $table->string('origen');
            $table->string('imagen_materias_primas');
            $table->string('codigo_materia_prima')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materias_primas');
    }
}
