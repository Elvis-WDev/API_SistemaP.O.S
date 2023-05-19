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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_venta');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_vendedor');
            $table->text('productos_venta');
            $table->decimal('impuesto_venta', 8, 2);
            $table->decimal('neto_venta', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('metodo_pago');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_vendedor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
