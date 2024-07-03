<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyewaTable extends Migration
{
    public function up()
    {
        Schema::create('penyewa', function (Blueprint $table) {
            $table->id('ID_Penyewa'); // This will create an auto-incrementing primary key
            $table->string('Nama_Lengkap', 100);
            $table->string('Username', 100)->unique();
            $table->string('Password');
            $table->string('Email', 100)->unique();
            $table->string('NoHP', 15);
            $table->string('Alamat', 300);
            $table->string('img_KTP', 2048)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyewa');
    }
}

