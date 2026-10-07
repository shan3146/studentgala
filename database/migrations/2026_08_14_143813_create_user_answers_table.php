<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_answers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('attempt_id')
                ->constrained('exam_attempts')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->string('selected_answer', 1)
                ->nullable();

            $table->boolean('is_correct')
                ->default(false);

            $table->timestamps();


            /*
             * Prevent the same question from being
             * answered twice in the same attempt.
             */

            $table->unique([
                'attempt_id',
                'question_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};