<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parceiros', function (Blueprint $table) {
            $table->id();
            
            $table->string('nome', 100);
            
            $table->string('logo', 150)->nullable();

            $table->text('sobre')->nullable();

            $table->string('usuario', 20)->unique();
            $table->string('senha', 32);

            $table->string('status', 2);
            $table->string('visibilidade', 2);

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
        Schema::dropIfExists('parceiros');
    }
}
