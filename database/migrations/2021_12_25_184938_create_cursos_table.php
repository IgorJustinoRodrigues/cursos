<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('imagem', 150)->nullable();
            $table->text('descricao')->nullable();

            $table->string('status', 2);
            $table->string('tipo', 2);
            $table->string('visibilidade', 2);
            $table->string('porcentagem_solicitacao_certificado', 3);
            $table->text('cooprodutor')->nullable();

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categoria_cursos');

            $table->unsignedBigInteger('professor_id');
            $table->foreign('professor_id')->references('id')->on('professors');

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
        Schema::dropIfExists('cursos');
    }
}
