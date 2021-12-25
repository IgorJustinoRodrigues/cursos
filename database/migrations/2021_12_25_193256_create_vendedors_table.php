<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedors', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('cpf', 11)->nullable()->unique();
            $table->string('avatar', 150)->nullable();

            $table->string('email', 200)->nullable();
            $table->string('whatsapp', 16)->nullable();
           
            $table->string('usuario', 20)->unique();
            $table->string('senha', 32);

            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');

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
        Schema::dropIfExists('vendedors');
    }
}
