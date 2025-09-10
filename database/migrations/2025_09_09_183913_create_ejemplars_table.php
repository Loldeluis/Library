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
    Schema::create('ejemplars', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('libro_id');
        $table->unsignedBigInteger('user_id');
        $table->string('codigo_interno')->unique();
        $table->date('fecha_adquisicion');
        $table->string('estado_actual');
        $table->string('ubicacion');
        $table->string('estado_fisico')->default('bueno');
        $table->string('fuente')->nullable();
        $table->timestamps();

        $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
{
    Schema::dropIfExists('ejemplars');
}

};
