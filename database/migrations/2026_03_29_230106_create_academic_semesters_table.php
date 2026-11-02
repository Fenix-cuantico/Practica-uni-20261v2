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
        Schema::create('academic_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('semester_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active');
            $table->string('curriculum_version');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_semesters');
    }
};
