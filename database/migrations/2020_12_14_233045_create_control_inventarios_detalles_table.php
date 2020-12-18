<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlInventariosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_inventarios_detalles', function (Blueprint $table) {
            $table->id();
            $table->text('observacion')->nullable();
            $table->string('estado');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('prima_id')->nullable();
            $table->unsignedBigInteger('empaque_id')->nullable();
            $table->foreign('prima_id')->references('id')->on('materias_primas');
            $table->foreign('empaque_id')->references('id')->on('materiales_empaques');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->unsignedBigInteger('control_inventarios_id');
            $table->foreign('control_inventarios_id')->references('id')->on('control_inventarios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_inventarios_detalles');
    }
}
