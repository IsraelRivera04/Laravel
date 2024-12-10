<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritosItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id');
            $table->string('producto_type');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->unsignedBigInteger('usuario_id')->nullable(); // ID del usuario
            $table->string('session_id')->nullable(); // ID de sesión para usuarios anónimos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carritos__items');
    }
}
