<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            
            $table->string('logo', 150)->nullable();

            $table->string('usuario', 20)->unique();
            $table->string('senha', 32);
            
            $table->string('email', 200)->nullable();
            $table->string('whatsapp', 16)->nullable();
            $table->text('contato')->nullable();

            $table->text('endereco')->nullable();
            $table->string('cidade', 50)->nullable();
            $table->string('estado', 2)->nullable();

            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('site')->nullable();

            $table->string('status', 2);

            $table->unsignedBigInteger('parceiro_id');
            $table->foreign('parceiro_id')->references('id')->on('parceiros');

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
        Schema::dropIfExists('unidades');
    }
}
