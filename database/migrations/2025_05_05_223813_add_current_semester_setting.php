<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::table('settings')->updateOrInsert(
        ['key' => 'current_semester'],
        ['value' => '2024-2025_2nd']
    );
}

public function down()
{
    DB::table('settings')->where('key', 'current_semester')->delete();
}

};
