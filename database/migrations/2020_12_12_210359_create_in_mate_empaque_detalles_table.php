<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInMateEmpaqueDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_mate_empaque_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad_empaque');
            $table->unsignedBigInteger('empaque_id');
            $table->unsignedBigInteger('in_materiales_empaque_id');
            $table->string('calidad');
            $table->boolean('laminacion');
            $table->string('color');
            $table->foreign('empaque_id')->references('id')->on('materiales_empaques');
            $table->foreign('in_materiales_empaque_id')->references('id')->on('ingresos_materiales_empaques');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_mate_empaque_detalles');
    }
}
