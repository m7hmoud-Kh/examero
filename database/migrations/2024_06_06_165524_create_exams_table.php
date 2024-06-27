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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('semster',[1,2])
            ->comment('
            1 => first semster
            , 2 => second semster');
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lesson_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('total_score');
            $table->decimal('result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
