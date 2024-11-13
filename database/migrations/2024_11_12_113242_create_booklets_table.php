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
        Schema::create('booklets', function (Blueprint $table) {
            $table->id('id');
            $table->integer('duration')->nullable();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->enum('status', [1, 0])->default(1);
            $table->string('subject', 50)->nullable();
            $table->integer('total_wattage');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booklets');
    }
};
