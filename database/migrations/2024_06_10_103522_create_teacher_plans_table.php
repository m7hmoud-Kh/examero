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
        Schema::create('teacher_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('points');
            $table->boolean('status')->default(false);
            $table->string('payment_id');
            $table->enum('type',['paypal','visa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_plans');
    }
};
