<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->char('letter', 1);
            $table->text('choice_text');
            $table->boolean('is_correct')->default(false);
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();
            $table->unique(['question_id', 'letter']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
