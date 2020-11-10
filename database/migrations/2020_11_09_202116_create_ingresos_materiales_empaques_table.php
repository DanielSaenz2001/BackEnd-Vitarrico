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
            $table->string('codigoEntrada')->unique();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->string('doc_completa');
            $table->date('fecha_elab');
            $table->date('fecha_fecha_venc');

            $table->string('olor')->nullable();
            $table->string('calidad_impresion')->nullable();
            $table->text('textos')->nullable();
            $table->boolean('laminacion')->nullable();
            $table->string('tamano')->nullable();
            $table->string('color')->nullable();

            $table->string('lote');
            $table->text('observacion');
            $table->unsignedBigInteger('recibe');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('recibe')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingresos_materiales_empaques');
    }
}
