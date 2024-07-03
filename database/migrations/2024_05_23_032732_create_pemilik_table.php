<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemilikTable extends Migration
{
    public function up()
    {
        Schema::create('pemilik', function (Blueprint $table) {
            $table->increments('ID_Pemilik');
            $table->string('NoHP', 13);
            $table->string('Username', 100);
            $table->string('Password', 100);
            $table->string('Nama_Lengkap', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemilik');
    }
};
