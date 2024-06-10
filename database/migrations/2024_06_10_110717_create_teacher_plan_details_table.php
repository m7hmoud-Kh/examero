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
        Schema::create('teacher_plan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_plans_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type',[1,2,3,4])->comment("
            1 => Exam
            2 => OPenEMis
            3 => Certificate
            4 => Specification");
            $table->integer('point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_plan_details');
    }
};
