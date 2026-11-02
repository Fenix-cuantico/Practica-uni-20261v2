<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('name');
            $table->string('specialty');
            $table->string('evaluation_system');
            $table->integer('theory_hours');
            $table->integer('practice_hours');
            $table->integer('lab_hours');
            $table->integer('credits');
            $table->integer('cycle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_plans');
    }
};
