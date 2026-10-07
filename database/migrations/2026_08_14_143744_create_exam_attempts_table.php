<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
	{
		Schema::create('exam_attempts', function (Blueprint $table) {

			$table->id();

			$table->foreignId('user_id')
				->constrained()
				->cascadeOnDelete();

			$table->foreignId('exam_id')
				->constrained('exams')
				->cascadeOnDelete();

			$table->timestamp('started_at');

			$table->timestamp('expires_at');

			$table->timestamp('submitted_at')
				->nullable();

			$table->decimal('score', 8, 2)
				->nullable();

			$table->unsignedInteger('total_questions')
				->default(0);

			$table->string('status')
				->default('in_progress');

			$table->timestamps();

			/*
			 * A user should not have two active attempts
			 * for the same exam.
			 */
			$table->index([
				'user_id',
				'exam_id',
				'status'
			]);
		});
	}

    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};