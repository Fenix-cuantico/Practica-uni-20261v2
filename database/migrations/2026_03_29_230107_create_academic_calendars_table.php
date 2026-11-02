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
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_semester_id')->constrained()->cascadeOnDelete();
            $table->string('period_code');
            $table->string('week_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('activity_description');
            $table->boolean('is_lecture_week');
            $table->integer('week_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
