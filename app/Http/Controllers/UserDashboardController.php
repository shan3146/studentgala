<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index($section = 'dashboard')
    {
        $user = Auth::user();

        // Available published exams
        $attemptedExamIds = ExamAttempt::where('user_id', $user->id) ->pluck('exam_id');

        $exams = Exam::where('status', 'published')
            ->whereNotIn('id', $attemptedExamIds) 
            ->withCount('questions') 
            ->orderByDesc('year') 
            ->get();

        // User's completed exams
        $attempts = ExamAttempt::where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'expired'])
            ->with('exam')
            ->latest('submitted_at')
            ->get();

        // Quick lookup
        $attemptedExams = $attempts->keyBy('exam_id');

        return view('user.dashboard', compact(
            'user',
            'exams',
            'attempts',
            'attemptedExams',
            'section'
        ));
    }
	public function attempted()
	{
		return $this->index('attempted');
	}

    public function settings()
    {
        return $this->index('settings');
    }
}