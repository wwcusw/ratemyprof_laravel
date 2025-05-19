<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('evaluations', function (Blueprint $table) {
        $table->unique(['user_id', 'faculty_user_id', 'semester'], 'unique_eval_per_prof_per_sem');
    });
}

public function down()
{
    Schema::table('evaluations', function (Blueprint $table) {
        $table->dropUnique('unique_eval_per_prof_per_sem');
    });
}

};
