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
            $table->integer('cantidad');
            $table->text('descripcion');
            $table->string('lote');
            $table->integer('material_empaque_id');
            $table->integer('producto_id');
            $table->integer('productos_despachos_id');
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
