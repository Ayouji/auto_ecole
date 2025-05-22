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
            $table->foreignId('serie_id')->constrained('series')->onDelete('cascade');
            $table->string('titre');
            $table->text('question_text')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_multiple')->default(false);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
