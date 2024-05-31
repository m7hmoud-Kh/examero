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
        Schema::create('admin_points', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->integer('points')->default(0);
            $table->enum('type',['1','2','3','4'])->comment('
            1 => Reward,
            2 => punishment,
            3 => warning
            4 => nothing
            ');
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_points');
    }
};
