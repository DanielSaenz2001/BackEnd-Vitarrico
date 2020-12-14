<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosMaterialesEmpaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_materiales_empaques', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nFactura')->unique();
            $table->unsignedBigInteger('proveedor_id');
            $table->string('doc_completa');
            $table->text('observacion');
            $table->unsignedBigInteger('recibe');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('recibe')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingresos_materiales_empaques');
    }
}
