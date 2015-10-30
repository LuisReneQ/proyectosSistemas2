<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asignacion', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
		  $table->integer('estudiante_id')->unsigned();
		  $table->foreign('estudiante_id')->references('id')->on('Estudiante');
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
        Schema::drop('Asignacion');
    }
}
