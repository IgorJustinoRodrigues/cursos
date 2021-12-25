<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 100);
            $table->string('email', 200)->unique();
            $table->string('senha', 32);
            $table->string('token', 32);
            $table->dateTime('validade_token', 32);
            $table->string('avatar', 150);
            $table->string('tipo', 2);
            $table->text('anotacoes')->nullable();
            $table->string('status', 1);
            
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
        Schema::dropIfExists('admins');
    }
}
