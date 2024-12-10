<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHoraInicioAndHoraFinalToEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->time('hora_inicio')->nullable()->after('fecha');
            $table->time('hora_final')->nullable()->after('hora_inicio');
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['hora_inicio', 'hora_final']);
        });
    }
}
