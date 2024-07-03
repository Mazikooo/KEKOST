<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarTable extends Migration
{
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->increments('ID_Kamar');
            $table->string('Keterangan', 200);
            $table->integer('Harga');
            $table->string('img_1', 50);
            $table->string('img_2', 50);
            $table->string('img_3', 50);
            $table->unsignedInteger('ID_Pemilik');
            $table->timestamps();

            $table->foreign('ID_Pemilik')->references('ID_Pemilik')->on('pemilik');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
};
