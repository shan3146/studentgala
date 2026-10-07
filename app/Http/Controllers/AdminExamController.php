<?php

namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminExamController extends Controller
{
    /**
     * Display all exams.
     */
    public function index(Request $request)
	{
		$query = Exam::query()
			->withCount([
				'questions',
				'attempts'
			]);

		/*
		|--------------------------------------------------------------------------
		| Department filter
		|--------------------------------------------------------------------------
		*/

		if ($request->filled('department')) {

			$query->where(
				'department',
				$request->department
			);
		}


		/*
		|--------------------------------------------------------------------------
		| Year filter
		|--------------------------------------------------------------------------
		*/

		if ($request->filled('year')) {

			$query->where(
				'year',
				$request->year
			);
		}


		/*
		|--------------------------------------------------------------------------
		| Subject filter
		|--------------------------------------------------------------------------
		*/

		if ($request->filled('subject')) {

			$query->where(
				'subject',
				$request->subject
			);
		}


		/*
		|--------------------------------------------------------------------------
		| Sorting
		|--------------------------------------------------------------------------
		*/

		$allowedSorts = [
			'department',
			'year',
			'subject',
			'post_name',
			'status',
			'created_at',
		];

		$sort = $request->get(
			'sort',
			'created_at'
		);

		if (!in_array($sort, $allowedSorts)) {

			$sort = 'created_at';
		}


		$direction = $request->get(
			'direction',
			'asc'
		);

		if (!in_array($direction, ['asc', 'desc'])) {

			$direction = 'asc';
		}


		/*
		|--------------------------------------------------------------------------
		| Fetch exams
		|--------------------------------------------------------------------------
		*/

		$exams = $query
			->orderBy(
				$sort,
				$direction
			)
			->orderBy(
				'id',
				'asc'
			)
			->get();


		/*
		|--------------------------------------------------------------------------
		| Filter dropdown values
		|--------------------------------------------------------------------------
		*/

		$departments = Exam::query()
			->whereNotNull('department')
			->where('department', '!=', '')
			->distinct()
			->orderBy('department')
			->pluck('department');


		$years = Exam::query()
			->whereNotNull('year')
			->distinct()
			->orderByDesc('year')
			->pluck('year');


		$subjects = Exam::query()
			->whereNotNull('subject')
			->where('subject', '!=', '')
			->distinct()
			->orderBy('subject')
			->pluck('subject');


		return view(
			'admin.exams.index',
			compact(
				'exams',
				'departments',
				'years',
				'subjects'
			)
		);
	}


    /**
     * Show Add Exam form.
     */
    public function create()
    {
        return view('admin.exams.create');
    }


    /**
     * Store exam and import questions.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
		
			'advertisement_no' => [
				'nullable',
				'string',
				'max:255',
			],

            'department' => [
                'required',
                'string',
                'max:255',
            ],

            'post_name' => [
                'required',
                'string',
                'max:255',
            ],

            'bps_scale' => [
                'required',
                'string',
                'max:50',
            ],

            'year' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'excel_file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:10240',
            ],
			
			'negative_marking' => [
				'required',
				'boolean',
			],

			'negative_marks' => [
				'required',
				'numeric',
				'min:0',
			],

			'time_per_question' => [
				'required',
				'integer',
				'min:1',
			],

        ]);


        DB::beginTransaction();

        try {

            /*
             * Create exam.
             */

            $exam = Exam::create([

				'department' =>
					$validated['department'],
					
				'advertisement_no' => 
					$validated['advertisement_no'] ?? null,


				'post_name' =>
					$validated['post_name'],

				'bps_scale' =>
					$validated['bps_scale'],

				'year' =>
					$validated['year'],

				'subject' =>
					$validated['subject'],

				'status' =>
					'draft',

				'created_by' =>
					auth()->id(),

				'negative_marking' =>
					$validated['negative_marking'],

				'negative_marks' =>
					$validated['negative_marks'],

				'time_per_question' =>
					$validated['time_per_question'],

			]);


            /*
             * Import Excel questions.
             */

            Excel::import(
                new QuestionsImport($exam->id),
                $request->file('excel_file')
            );


            DB::commit();


            return redirect()
                ->route('admin.exams.index')
                ->with(
                    'success',
                    'Exam created successfully.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->withErrors([
                    'excel_file' =>
                        'Exam could not be imported: '
                        . $e->getMessage(),
                ]);
        }
    }
	
	public function show(Exam $exam)
	{
		$exam->load([
			'questions'
		]);

		return view(
			'admin.exams.show',
			compact('exam')
		);
	}
	
	public function toggleStatus(Exam $exam)
		{
			if ($exam->status === 'published') {

				$exam->status = 'draft';

			} else {

				$exam->status = 'published';

			}

			$exam->save();

			return redirect()
				->back()
				->with(
					'success',
					'Exam status changed successfully.'
				);
		}
}