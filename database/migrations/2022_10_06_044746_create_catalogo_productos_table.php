<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_productos', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('filename');
            $table->string('color');
            $table->smallInteger('stock')->default(1);
            $table->bigInteger('producto_id')->unsigned()->nullable();
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('products');
            $table->foreign('color_id')->references('id')->on('colorproductos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogo_productos');
    }
}
