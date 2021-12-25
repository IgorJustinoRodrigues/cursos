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
            $table->string('cpf', 11)->unique();
            $table->string('rg', 20)->unique();

            $table->string('avatar', 150);

            $table->string('email', 200);
            $table->string('whatsapp', 16);
            $table->string('senha', 32)->default('123456');

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
