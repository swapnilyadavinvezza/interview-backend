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
        Schema::create('exam_enrollments', function (Blueprint $table) {
            $table->id('exam_id');
            $table->foreignId('booklet_id')->constrained('booklets', 'booklet_id');
            $table->dateTime('exam_date');
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->integer('marks_obtained')->nullable();
            $table->string('comments')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_enrollments');
    }
};
