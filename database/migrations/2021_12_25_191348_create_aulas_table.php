<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();

            $table->integer('ordem')->nullable();
            $table->string('tipo', 1);

            $table->string('nome', 100);
            $table->text('descricao')->nullable();

            $table->text('video')->nullable();
            $table->text('texto')->nullable();

            $table->string('duracao', 6);
            $table->string('avaliacao', 1);

            $table->string('status', 2);

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

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
        Schema::dropIfExists('aulas');
    }
}
