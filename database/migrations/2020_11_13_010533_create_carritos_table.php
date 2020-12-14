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
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->integer('cantidad_producto')->nullable();
            $table->integer('cantidad_materias')->nullable();
            $table->integer('cantidad_empaque')->nullable();
            $table->string('tipo')->nullable();


            $table->string('calidad')->nullable();
            $table->boolean('laminacion')->nullable();
            $table->string('color')->nullable();
            
            $table->text('integridad')->nullable();
            $table->boolean('plagas')->nullable();
            $table->boolean('materias_extranas')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('empaque_id')->nullable();
            $table->unsignedBigInteger('materias_primas_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('empaque_id')->references('id')->on('materiales_empaques');
            $table->foreign('materias_primas_id')->references('id')->on('materias_primas');
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
