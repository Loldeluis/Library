<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Libro_autor', function (Blueprint $table) {
        $table->unsignedBigInteger('libro_id');
        $table->unsignedBigInteger('autor_id');

        $table->primary(['libro_id','autor_id']);

        $table->foreign('libro_id')
              ->references('id')->on('libros')
              ->onDelete('cascade');

        $table->foreign('autor_id')
              ->references('id')->on('autores')
              ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autors');
    }
};
