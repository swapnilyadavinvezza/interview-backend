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
        Schema::create('booklet_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booklet_id');
            $table->enum('question_type', ['mcq', 'text', 'image']);
            $table->integer('marks')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booklet_questions');
    }
};
