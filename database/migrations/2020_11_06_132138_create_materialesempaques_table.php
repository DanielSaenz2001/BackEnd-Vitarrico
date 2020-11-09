<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialesempaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales_empaques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('stock');
            $table->text('descripcion');
            $table->float('peso_neto');
            $table->float('peso_bruto');
            $table->string('medidas');
            $table->string('imagen_material_empaques');
            $table->string('codigo_materiales_empaques')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materiales_empaques');
    }
}
