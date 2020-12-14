<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInMatePrimasDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_mate_primas_detalles', function (Blueprint $table) {
            
            $table->id();
            $table->integer('cantidad_prima');
            $table->unsignedBigInteger('prima_id');
            $table->unsignedBigInteger('in_materias_prima_id');
            $table->text('integridad');
            $table->boolean('plagas');
            $table->boolean('materias_extranas');
            $table->foreign('prima_id')->references('id')->on('materias_primas');
            $table->foreign('in_materias_prima_id')->references('id')->on('ingresos_materias_primas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_mate_primas_detalles');
    }
}
