<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserExamController extends Controller
{
    /**
     * Display published exams.
     */
	public function index()
	{
		$user = Auth::user();

		// Get exam IDs already attempted by this user
		$attemptedExamIds = ExamAttempt::where('user_id', $user->id)
			->whereIn('status', ['submitted', 'expired'])
			->pluck('exam_id');

		// Only show published exams that this user has NOT attempted
		$exams = Exam::where('status', 'published')
			->whereNotIn('id', $attemptedExamIds)
			->withCount('questions')
			->orderByDesc('year')
			->get();

		return view(
			'user.exams.index',
			compact('exams')
		);
	}


    /**
     * Display exam information.
     */
	 
	public function attempted()
	{
		$user = Auth::user();

		$attempts = ExamAttempt::where('user_id', $user->id)
			->whereIn('status', ['submitted', 'expired'])
			->with('exam')
			->latest('submitted_at')
			->get();

		return view('user.exams.attempted', compact('attempts'));
	}	
	 
    public function show(Exam $exam)
    {
        abort_unless(
            $exam->status === 'published',
            404
        );

        $exam->loadCount('questions');

        /*
         * 75 seconds per question.
         */
        $secondsPerQuestion = $exam->seconds_per_question ?? 75;;

        $totalSeconds =
            $exam->questions_count *
            $secondsPerQuestion;

        $totalMinutes =
            ceil($totalSeconds / 60);

        return view(
            'user.exams.show',
            compact(
                'exam',
                'totalSeconds',
                'totalMinutes',
                'secondsPerQuestion'
            )
        );
    }


    /**
     * Display examination instructions.
     */
    public function instructions(Exam $exam)
    {
        abort_unless(
            $exam->status === 'published',
            404
        );

        $exam->loadCount('questions');

        $secondsPerQuestion = $exam->seconds_per_question ?? 75;;

        $totalSeconds =
            $exam->questions_count *
            $secondsPerQuestion;

        $totalMinutes =
            ceil($totalSeconds / 60);

        return view(
            'user.exams.instructions',
            compact(
                'exam',
                'totalSeconds',
                'totalMinutes',
                'secondsPerQuestion'
            )
        );
    }


    /**
     * Start or resume an examination.
     */
	public function start(Exam $exam)
	{
		$user = Auth::user();

		// Check whether the user has already completed this exam
		$existingAttempt = ExamAttempt::where('user_id', $user->id)
			->where('exam_id', $exam->id)
			->whereIn('status', ['submitted', 'expired'])
			->first();

		if ($existingAttempt) {

			return redirect()->route(
				'user.exams.result',
				$existingAttempt->id
			)->with(
				'info',
				'You have already attempted this exam.'
			);
		}

	// Your existing start-exam code continues here...
	$exam->loadCount('questions');

	$secondsPerQuestion =
		$exam->seconds_per_question ?? 75;

	$totalSeconds =
		$exam->questions_count * $secondsPerQuestion;

	$startedAt = now();
	$expiresAt = $startedAt->copy()->addSeconds($totalSeconds);
	$attempt = ExamAttempt::create([
    'user_id' => $user->id,
    'exam_id' => $exam->id,
    'started_at' => $startedAt,
    'expires_at' => $expiresAt,
    'total_questions' => $exam->questions_count,
    'score' => 0,
    'status' => 'in_progress',
	]);
		
			
	return redirect()->route(
    'user.exams.take',
    $attempt->id
	);
	}
		
	public function take(ExamAttempt $attempt)
	{
		/*
		 * Security:
		 * The logged-in user can only access
		 * his own attempt.
		 */
		abort_unless(
			$attempt->user_id === Auth::id(),
			403
		);

		/*
		 * Do not allow an already submitted attempt
		 * to be opened again.
		 */
		if ($attempt->status !== 'in_progress') {

			return redirect()
				->route(
					'user.exams.result',
					$attempt->id
				);
		}

		/*
		 * Check whether the time has expired.
		 */
		if (now()->greaterThanOrEqualTo($attempt->expires_at)) {

			$attempt->update([
				'status' => 'expired',
				'submitted_at' => now(),
			]);

			return redirect()
				->route(
					'user.exams.result',
					$attempt->id
				);
		}

		/*
		 * Load exam and questions.
		 *
		 * IMPORTANT:
		 * We deliberately do NOT expose correct_ans
		 * separately to JavaScript.
		 */
		$attempt->load([
			'exam.questions'
		]);

		/*
		 * Load answers already saved by this user.
		 */
		$answers = $attempt->answers()
			->get()
			->keyBy('question_id');

		return view(
			'user.exams.take',
			compact(
				'attempt',
				'answers'
			)
		);
	}
	
	public function saveAnswer(
    Request $request,
    ExamAttempt $attempt) 
	{
		abort_unless(
			$attempt->user_id === Auth::id(),
			403
		);

		if ($attempt->status !== 'in_progress') {
			return response()->json([
				'success' => false,
				'message' => 'Exam has already ended.'
			], 422);
		}

		if (now()->greaterThanOrEqualTo($attempt->expires_at)) {

			$attempt->update([
				'status' => 'expired',
				'submitted_at' => now(),
			]);

			return response()->json([
				'success' => false,
				'message' => 'Exam time has expired.'
			], 422);
		}

		$validated = $request->validate([
			'question_id' => [
				'required',
				'integer',
				'exists:questions,id',
			],

			'selected_option' => [
				'required',
				'in:A,B,C,D',
			],
		]);

		/*
		 * Make sure the question belongs
		 * to this exam.
		 */
		$question = $attempt->exam
			->questions()
			->where(
				'id',
				$validated['question_id']
			)
			->firstOrFail();

		/*
		 * We don't calculate the final score here.
		 *
		 * The answer is simply saved.
		 */
		$attempt->answers()->updateOrCreate(
			[
				'question_id' =>
					$question->id,
			],
			[
				'selected_option' =>
					$validated['selected_option'],
			]
		);

		return response()->json([
			'success' => true,
		]);
	}
	
	public function submit(ExamAttempt $attempt)
	{
		abort_unless(
			$attempt->user_id === Auth::id(),
			403
		);

		/*
		 * Do not process an already submitted attempt again.
		 */
		if ($attempt->status !== 'in_progress') {

			return redirect()
				->route(
					'user.exams.result',
					$attempt->id
				);
		}


		$attempt->load([
			'exam.questions',
			'answers'
		]);


		/*
		 * Determine whether the examination
		 * has negative marking.
		 */
		$negativeMarking =
			(bool) $attempt->exam->negative_marking;


		/*
		 * Negative marking value.
		 *
		 * For now:
		 * Wrong answer = -0.25
		 */
		$negativeMarks = 0.25;


		$score = 0;

		$correctAnswers = 0;

		$wrongAnswers = 0;

		$unanswered = 0;


		/*
		 * Get submitted answers indexed by question ID.
		 */
		$answersByQuestion =
			$attempt->answers->keyBy(
				'question_id'
			);


		/*
		 * Evaluate EVERY question.
		 */
		foreach (
			$attempt->exam->questions
			as $question
		) {

			$answer =
				$answersByQuestion->get(
					$question->id
				);


			/*
			 * No answer.
			 */
			if (
				!$answer ||
				empty($answer->selected_option)
			) {

				$unanswered++;

				continue;
			}


			/*
			 * Correct answer.
			 */
			if (
				strtoupper(
					trim($answer->selected_option)
				)
				===
				strtoupper(
					trim($question->correct_ans)
				)
			) {

				$marks = 1.00;

				$correctAnswers++;

				$score += $marks;


				$answer->update([
					'is_correct' => true,
					'marks_awarded' => $marks,
				]);

			}

			/*
			 * Wrong answer.
			 */
			else {

				$wrongAnswers++;


				$marks =
					$negativeMarking
					? -$negativeMarks
					: 0;


				$score += $marks;


				$answer->update([
					'is_correct' => false,
					'marks_awarded' => $marks,
				]);
			}
		}


		/*
		 * Round the final score.
		 */
		$score = round(
			$score,
			2
		);


		/*
		 * Submit the attempt.
		 */
		$attempt->update([

			'score' =>
				$score,

			'status' =>
				'submitted',

			'submitted_at' =>
				now(),

		]);


		return redirect()
			->route(
				'user.exams.result',
				$attempt->id
			);
	}
	public function result(ExamAttempt $attempt)
	{
		abort_unless(
			$attempt->user_id === Auth::id(),
			403
		);


		$attempt->load([
			'user',
			'exam.questions',
			'answers.question',
		]);


		$totalQuestions =
			$attempt->exam->questions->count();


		$answers =
			$attempt->answers;


		$attempted =
			$answers->whereNotNull(
				'selected_option'
			)->count();


		$correct =
			$answers->where(
				'is_correct',
				true
			)->count();


		$wrong =
			$answers
				->whereNotNull('selected_option')
				->where(
					'is_correct',
					false
				)
				->count();


		$unanswered =
			max(
				0,
				$totalQuestions - $attempted
			);


		$totalMarks =
			$totalQuestions;


		$score =
			(float) $attempt->score;


		$percentage =
			$totalMarks > 0
			? round(
				($score / $totalMarks) * 100,
				2
			)
			: 0;


		/*
		 * Pass percentage.
		 *
		 * Change this later if your exam
		 * has a different passing percentage.
		 */
		$passPercentage = 50;


		$passed =
			$percentage >= $passPercentage;


		/*
		 * Time taken.
		 */
		$timeTakenSeconds = 0;

		if (
			$attempt->started_at &&
			$attempt->submitted_at
		) {

			$timeTakenSeconds =
				$attempt->started_at
					->diffInSeconds(
						$attempt->submitted_at
					);
		}


		$hours =
			floor(
				$timeTakenSeconds / 3600
			);


		$minutes =
			floor(
				($timeTakenSeconds % 3600) / 60
			);


		$seconds =
			$timeTakenSeconds % 60;


		$timeTaken =
			sprintf(
				'%02d:%02d:%02d',
				$hours,
				$minutes,
				$seconds
			);


		return view(
			'user.exams.result',
			compact(
				'attempt',
				'totalQuestions',
				'attempted',
				'correct',
				'wrong',
				'unanswered',
				'totalMarks',
				'score',
				'percentage',
				'passPercentage',
				'passed',
				'timeTaken'
			)
		);
	}
}