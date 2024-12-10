<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('comentarios', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('juego_id');
        $table->unsignedBigInteger('usuario_id');
        $table->text('comentario');
        $table->decimal('valoracion', 4, 2);
        $table->timestamps();

        $table->foreign('juego_id')->references('id')->on('juegos')->onDelete('cascade');
        $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
    });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
