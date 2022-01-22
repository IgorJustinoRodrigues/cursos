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
            $table->date('nascimento')->nullable();
            $table->string('sexo', 1)->nullable();

            $table->string('avatar', 150)->nullable();

            $table->string('email', 200)->unique();
            $table->string('whatsapp', 16)->nullable();
            $table->string('telefone', 16)->nullable();
            $table->text('contato')->nullable();

            $table->string('cidade', 50)->nullable();
            $table->string('estado', 2)->nullable();

            $table->string('senha', 32);
            
            $table->string('token', 32)->nullable();
            $table->date('recupera_senha')->nullable();

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
