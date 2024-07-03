<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->increments('ID_Pemesanan');
            $table->date('Tgl_Pemesanan');
            $table->unsignedInteger('ID_Penyewa');
            $table->unsignedInteger('ID_Kamar');
            $table->timestamps();

            $table->foreign('ID_Penyewa')->references('ID_Penyewa')->on('penyewa');
            $table->foreign('ID_Kamar')->references('ID_Kamar')->on('kamar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
};
