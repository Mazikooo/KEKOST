<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIdPenyewaColumnInPenyewaTable extends Migration
{
    public function up()
    {
        Schema::table('penyewa', function (Blueprint $table) {
            $table->id('ID_Penyewa')->change(); // This will change the column to auto-incrementing primary key
        });
    }

    public function down()
    {
        Schema::table('penyewa', function (Blueprint $table) {
            // Reverse the change if necessary
            $table->bigInteger('ID_Penyewa')->change();
        });
    }
}
