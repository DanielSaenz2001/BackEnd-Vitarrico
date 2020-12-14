<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosElaboracionesDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_elaboraciones_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad_materias');
            $table->unsignedBigInteger('materias_id');
            $table->unsignedBigInteger('prod_elabo_id');
            $table->foreign('materias_id')->references('id')->on('materias_primas');
            $table->foreign('prod_elabo_id')->references('id')->on('productos_elaboraciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_elaboraciones_detalles');
    }
}
