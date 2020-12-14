<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegulacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->text('motivo');
            $table->string('tipo');
            $table->date('fecha');
            $table->string('actividad');
            $table->unsignedBigInteger('responsable');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('prima_id')->nullable();
            $table->unsignedBigInteger('empaque_id')->nullable();
            $table->foreign('prima_id')->references('id')->on('materias_primas');
            $table->foreign('empaque_id')->references('id')->on('materiales_empaques');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('responsable')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regulaciones');
    }
}
