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
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('ruc')->nullable();
            $table->string('military_lib')->nullable();
            $table->string('license_category')->nullable();
            $table->string('vehicle_info')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('marriage_date')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'gender', 'birthdate', 'ruc', 'military_lib',
                'license_category', 'vehicle_info', 'marital_status', 'marriage_date',
                'blood_type', 'personal_email', 'birthplace', 'address'
            ]);
        });
    }
};
