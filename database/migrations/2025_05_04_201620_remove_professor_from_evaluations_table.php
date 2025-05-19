<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveProfessorFromEvaluationsTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('evaluations', 'professor')) {
            Schema::table('evaluations', function (Blueprint $table) {
                $table->dropColumn('professor');
            });
        }
    }

    public function down()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->string('professor')->nullable();
        });
    }
}

