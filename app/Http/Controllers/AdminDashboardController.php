<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exam;
use App\Models\ExamAttempt;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::where('role', 'user')->count();

        $activeUsers = User::where('role', 'user')
            ->whereNotNull('email_verified_at')
            ->count();

        $newUsersThisMonth = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | EXAMS
        |--------------------------------------------------------------------------
        */

        $totalExams = Exam::count();

        $publishedExams = Exam::where(
            'status',
            'published'
        )->count();

        $draftExams = Exam::where(
            'status',
            'draft'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | ATTEMPTS
        |--------------------------------------------------------------------------
        */

        $totalAttempts = ExamAttempt::count();

        $completedAttempts = ExamAttempt::where(
            'status',
            'submitted'
        )->count();

        $inProgressAttempts = ExamAttempt::where(
            'status',
            'in_progress'
        )->count();

        $expiredAttempts = ExamAttempt::where(
            'status',
            'expired'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE
        |--------------------------------------------------------------------------
        */

        $performanceAttempts = ExamAttempt::whereIn(
            'status',
            ['submitted', 'expired']
        )->get();


        $totalPerformanceAttempts =
            $performanceAttempts->count();


        $passedAttempts = 0;

        $failedAttempts = 0;

        $totalPercentage = 0;


        foreach ($performanceAttempts as $attempt) {

            $totalQuestions =
                $attempt->total_questions;


            if ($totalQuestions <= 0) {
                continue;
            }


            $percentage =
                ($attempt->score / $totalQuestions) * 100;


            $totalPercentage += $percentage;


            if ($percentage >= 50) {

                $passedAttempts++;

            } else {

                $failedAttempts++;

            }
        }


        $averagePercentage =
            $totalPerformanceAttempts > 0
            ? round(
                $totalPercentage /
                $totalPerformanceAttempts,
                2
            )
            : 0;


        $passRate =
            $totalPerformanceAttempts > 0
            ? round(
                ($passedAttempts /
                $totalPerformanceAttempts) * 100,
                2
            )
            : 0;


        $failRate =
            $totalPerformanceAttempts > 0
            ? round(
                ($failedAttempts /
                $totalPerformanceAttempts) * 100,
                2
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | RECENT ATTEMPTS
        |--------------------------------------------------------------------------
        */

        $recentAttempts = ExamAttempt::with([
                'user',
                'exam'
            ])
            ->whereIn(
                'status',
                ['submitted', 'expired']
            )
            ->latest('submitted_at')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'activeUsers',
                'newUsersThisMonth',

                'totalExams',
                'publishedExams',
                'draftExams',

                'totalAttempts',
                'completedAttempts',
                'inProgressAttempts',
                'expiredAttempts',

                'averagePercentage',
                'passedAttempts',
                'failedAttempts',
                'passRate',
                'failRate',

                'recentAttempts'
            )
        );
    }
}