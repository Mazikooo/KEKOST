<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimoniTable extends Migration
{
    public function up()
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->increments('ID_Testimoni');
            $table->string('Username', 100);
            $table->integer('Rating');
            $table->string('Pesan', 500);
            $table->unsignedInteger('ID_Kamar');
            $table->timestamps();

            $table->foreign('ID_Kamar')->references('ID_Kamar')->on('kamar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimoni');
    }
};
