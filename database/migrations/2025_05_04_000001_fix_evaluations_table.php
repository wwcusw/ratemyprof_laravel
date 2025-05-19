<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->string('faculty_user_id')->after('user_id')->nullable();
            $table->string('semester')->after('faculty_user_id')->default('2024-2025_2nd');
            $table->text('comment')->after('q10')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn(['faculty_user_id', 'semester', 'comment']);
        });
    }
};
