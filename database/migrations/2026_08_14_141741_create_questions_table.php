<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnDelete();

            /*
             * This corresponds to question_id
             * from your Excel file.
             */
            $table->string('question_id');

            $table->text('question_statement');

            $table->text('ans_a')->nullable();

            $table->text('ans_b')->nullable();

            $table->text('ans_c')->nullable();

            $table->text('ans_d')->nullable();

            $table->enum('correct_ans', [
                'A',
                'B',
                'C',
                'D'
            ]);

            $table->timestamps();

            $table->index('exam_id');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};