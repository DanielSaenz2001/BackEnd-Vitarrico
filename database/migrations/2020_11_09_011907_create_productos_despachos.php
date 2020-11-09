<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosDespachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_despachos', function (Blueprint $table) {
            $table->id();
            $table->string('vehiculo');
            $table->string('nombreConductor');
            $table->date('fecha');
            $table->string('Nrelacion');
            $table->integer('responsable');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_despachos');
    }
}
