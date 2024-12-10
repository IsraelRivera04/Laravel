<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('edicion', 50)->nullable();
            $table->integer('num_jugadores_min');
            $table->integer('num_jugadores_max');
            $table->integer('edad_recomendada');
            $table->integer('duracion_aprox');
            $table->string('editor', 100)->nullable();
            $table->string('disenador', 100)->nullable();
            $table->integer('ano_publicacion')->nullable();
            $table->decimal('dureza', 3, 2)->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->longText('imagen')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('oferta')->default(false);
            $table->decimal('precio_oferta', 8, 2)->nullable();

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
        Schema::dropIfExists('juegos');
    }
}
