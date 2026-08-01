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
        Schema::create('customer_body_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('height_cm');
            $table->integer('weight_kg');
            $table->integer('chest_circumference_cm')->nullable();
            $table->integer('waist_circumference_cm')->nullable();
            $table->integer('hips_circumference_cm')->nullable();
            $table->integer('shoulder_width_cm')->nullable();
            $table->string('preference')->default('regular');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_body_profiles');
    }
};
