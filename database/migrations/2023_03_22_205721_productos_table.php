<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_category');
            $table->string('codigo_producto')->unique();
            $table->text('descripcion_producto');
            $table->string('url_img_producto')->nullable();
            $table->integer('stock_producto');
            $table->decimal('precio_compra_producto', 10, 2);
            $table->decimal('precio_venta_producto', 10, 2);
            $table->integer('ventas_producto')->default(0);
            $table->dateTime('fecha');
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
