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
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->id('answer_id');
            $table->foreignId('question_id');
            $table->foreignId('user_id');
            $table->text('status')->nullable();
            $table->integer('marks_awarded')->nullable();
            $table->integer('exam_id')->nullable();
            $table->foreignId('booklet_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_answers');
    }
};
