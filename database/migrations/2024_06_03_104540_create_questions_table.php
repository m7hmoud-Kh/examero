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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('point')->default(1.0);
            $table->foreignId('group_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_type_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('level',[1,2,3,4,5])
            ->comment('
            1 => esay
            2 => medium
            3 => hard
            4 => Higher thinking skills
            5 => External question');
            $table->enum('semster',[1,2])
            ->comment('
            1 => first semster
            , 2 => second semster');
            $table->enum('for',[1,2,3])
            ->comment('
            1 => both ,
            2 => male,
            3 => female');
            $table->enum('status',[1,2,3])
            ->comment("
            1 => waiting,
            2 => accpted
            3 => Refused")->default(1);
            $table->boolean('has_branch')->default(false);
            $table->boolean('is_choose')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
