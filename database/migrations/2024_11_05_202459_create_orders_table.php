<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
        $table->string('estado')->default('pendiente');
        $table->decimal('total', 10, 2);
        $table->string('direccion')->nullable();
        $table->string('telefono')->nullable();
        $table->string('metodo_pago')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

