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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size_label');
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('body_length_cm')->nullable();
            $table->integer('chest_width_cm')->nullable();
            $table->integer('waist_width_cm')->nullable();
            $table->integer('shoulder_width_cm')->nullable();
            $table->integer('sleeve_length_cm')->nullable();
            $table->integer('pants_length_cm')->nullable();
            $table->integer('inseam_cm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
