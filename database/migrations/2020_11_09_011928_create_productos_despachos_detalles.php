<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosDespachosDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_despachos_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad_producto');
            $table->integer('cantidad_empaque');
            $table->unsignedBigInteger('material_empaque_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('productos_despachos_id');
            $table->foreign('material_empaque_id')->references('id')->on('materiales_empaques');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('productos_despachos_id')->references('id')->on('productos_despachos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_despachos_detalles');
    }
}
