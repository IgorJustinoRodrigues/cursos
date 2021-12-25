<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->date('nascimento');
            $table->string('sexo', 1)->nullable();
            
            $table->string('cpf', 11)->nullable()->unique();
            $table->string('rg', 20)->nullable()->unique();
            
            $table->string('nome_responsavel', 100)->nullable();
            $table->string('cpf_responsavel', 11)->nullable()->unique();
            $table->string('rg_responsavel', 20)->nullable()->unique();

            $table->string('avatar', 150)->nullable();

            $table->string('email', 200)->nullable();
            $table->string('whatsapp', 16)->nullable();
            $table->string('telefone', 16)->nullable();
            $table->text('contato')->nullable();

            $table->text('endereco')->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('estado', 2)->nullable();

            $table->string('usuario', 20)->unique();
            $table->string('senha', 32);

            $table->integer('pontuacao');

            $table->string('status', 2);

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
        Schema::dropIfExists('alunos');
    }
}
