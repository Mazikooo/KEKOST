<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RehashPenyewaPasswords extends Migration
{
    public function up()
    {
        // Fetch all penyewa records
        $penyewaRecords = DB::table('penyewa')->get();

        // Loop through each record
        foreach ($penyewaRecords as $penyewa) {
            // Check if the current password needs rehashing
            if (!Hash::needsRehash($penyewa->Password)) {
                // Rehash the password
                $newPassword = Hash::make($penyewa->Password);

                // Update the password in the database
                DB::table('penyewa')
                    ->where('ID_Penyewa', $penyewa->ID_Penyewa)
                    ->update(['Password' => $newPassword]);
            }
        }
    }

    public function down()
    {
        // This migration is irreversible, so we won't implement the down method.
    }
};

