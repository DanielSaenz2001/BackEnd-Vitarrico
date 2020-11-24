<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad_producto');
            $table->text('descripcion');
            $table->text('lote');
            $table->string('tipo');
            $table->integer('cantidad_empaque');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empaque_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('empaque_id')->references('id')->on('materiales_empaques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carritos');
    }
}
