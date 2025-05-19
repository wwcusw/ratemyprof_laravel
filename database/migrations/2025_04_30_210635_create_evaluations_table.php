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
    Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // student
        $table->string('professor');
        $table->tinyInteger('q1');
        $table->tinyInteger('q2');
        $table->tinyInteger('q3');
        $table->tinyInteger('q4');
        $table->tinyInteger('q5');
        $table->tinyInteger('q6');
        $table->tinyInteger('q7');
        $table->tinyInteger('q8');
        $table->tinyInteger('q9');
        $table->tinyInteger('q10');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
