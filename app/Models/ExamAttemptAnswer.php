<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAttemptAnswer extends Model
{
    protected $table = 'exam_attempt_answers';

    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'selected_option',
        'is_correct',
        'marks_awarded',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'marks_awarded' => 'decimal:2',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(
            ExamAttempt::class,
            'exam_attempt_id'
        );
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            Question::class,
            'question_id'
        );
    }
}