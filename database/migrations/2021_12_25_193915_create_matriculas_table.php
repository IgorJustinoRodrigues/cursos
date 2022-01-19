<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            
            $table->string('ativacao', 15);
            $table->string('tipo_pagamento', 1);
            $table->string('quant_parcelas', 2)->nullable();
            $table->string('mes_inicio_pagamento', 7)->nullable();
            $table->string('valor_venda', 2)->nullable();

            $table->string('nivel_curso', 2)->nullable();

            $table->string('status', 1);

            $table->unsignedBigInteger('aluno_id')->nullable();
            $table->foreign('aluno_id')->references('id')->on('alunos');

            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');

            $table->unsignedBigInteger('curso_id')->nullable();
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');

            $table->unsignedBigInteger('cupom_id')->nullable();
            $table->foreign('cupom_id')->references('id')->on('cupoms');

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
        Schema::dropIfExists('matriculas');
    }
}
