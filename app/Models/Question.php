<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'exam_id',
        'question_id',
        'question_statement',
        'ans_a',
        'ans_b',
        'ans_c',
        'ans_d',
        'correct_ans',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
	public function answers()
	{
		return $this->hasMany(
			ExamAnswer::class
		);
	}
}