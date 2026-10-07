<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

		protected $fillable = [
		'name',
		'email',
		'password',
		'google_id',
		'avatar',
		'role',
		'phone',
		'date_of_birth',
		'gender',
		'address',
		'city',
		'country',
	];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }
	
	public function examAttempts(): HasMany
	{
		return $this->hasMany(ExamAttempt::class);
	}
}