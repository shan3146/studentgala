<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'department',
		'advertisement_no',
		'post_name',
		'bps_scale',
		'year',
		'subject',
		'status',
		'created_by',
		'negative_marking',
		'negative_marks',
		'time_per_question',
    ];
	protected $casts = [
    'negative_marking' => 'boolean',
	];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
	
	public function getTotalTimeSecondsAttribute(): int
	{
		return $this->questions()->count()
			* $this->time_per_question;
	}

	public function attempts(): HasMany
	{
		return $this->hasMany(ExamAttempt::class);
	}

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}