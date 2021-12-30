<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            
            $table->string('nome', 100);

            $table->string('avatar', 150)->nullable();
            
            $table->string('email', 200)->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('site')->nullable();

            $table->text('curriculo')->nullable();

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
        Schema::dropIfExists('professors');
    }
}
