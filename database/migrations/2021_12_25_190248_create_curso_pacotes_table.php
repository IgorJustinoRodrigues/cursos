<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoPacotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_pacotes', function (Blueprint $table) {
            $table->unsignedBigInteger('pacote_id');
            $table->unsignedBigInteger('curso_id');

            $table->primary(['pacote_id', 'curso_id']); 

            $table->foreign('pacote_id')->references('id')->on('pacotes');
            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso_pacotes');
    }
}
