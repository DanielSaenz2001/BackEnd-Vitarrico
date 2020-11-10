<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosMateriasPrimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_materias_primas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nFactura')->unique();
            $table->string('codigoEntrada')->unique();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->string('doc_completa');
            $table->date('fecha_elab');
            $table->date('fecha_fecha_venc');

            $table->string('integridad')->nullable();
            $table->boolean('ausencia_plaga')->nullable();
            $table->boolean('ausencia_extraña')->nullable();
            $table->string('rotulado')->nullable();
            $table->string('caracteristicas')->nullable();

            $table->string('lote');
            $table->text('observacion');
            $table->unsignedBigInteger('recibe');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('recibe')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_materias_primas');
    }
}
