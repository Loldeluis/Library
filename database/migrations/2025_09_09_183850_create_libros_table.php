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
        Schema::create('libros', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('isbn', 20)->unique();
        $table->year('anio_publicacion')->nullable();
        $table->integer('edicion')->nullable();
        $table->string('idioma', 50)->nullable();
        $table->integer('paginas')->nullable();
        $table->text('sinopsis')->nullable();
        $table->string('formato', 50)->nullable();
        $table->string('serie', 100)->nullable();
        $table->unsignedBigInteger('id_editorial');
        $table->timestamps();

              
        //$table->foreign('id_editorial')
             
        //->references('id')->on('editorials')
           //   ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libros');
    }
};
