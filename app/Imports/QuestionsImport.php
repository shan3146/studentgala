<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class QuestionsImport implements
    ToCollection,
    WithHeadingRow,
    SkipsEmptyRows
{
    /**
     * Exam ID to which the questions belong.
     */
    protected int $examId;


    /**
     * Create importer.
     */
    public function __construct(int $examId)
    {
        $this->examId = $examId;
    }


    /**
     * Import questions.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            $row = $row->toArray();


            /*
            |--------------------------------------------------------------------------
            | Skip completely empty rows
            |--------------------------------------------------------------------------
            */

            if (
                empty(trim((string) ($row['question_statement'] ?? ''))) &&
                empty(trim((string) ($row['ans_a'] ?? ''))) &&
                empty(trim((string) ($row['ans_b'] ?? ''))) &&
                empty(trim((string) ($row['ans_c'] ?? ''))) &&
                empty(trim((string) ($row['ans_d'] ?? ''))) &&
                empty(trim((string) ($row['correct_ans'] ?? '')))
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Validate row
            |--------------------------------------------------------------------------
            */

            $validator = Validator::make($row, [

                'question_statement' => [
                    'required',
                    'string',
                ],

                'ans_a' => [
                    'required',
                    'string',
                ],

                'ans_b' => [
                    'required',
                    'string',
                ],

                'ans_c' => [
                    'required',
                    'string',
                ],

                'ans_d' => [
                    'required',
                    'string',
                ],

                'correct_ans' => [
                    'required',
                    'string',
                ],

            ]);


            if ($validator->fails()) {

                $excelRow = $index + 2;

                throw new \Exception(
                    'Invalid question data on Excel row '
                    . $excelRow
                    . ': '
                    . implode(
                        ' ',
                        $validator->errors()->all()
                    )
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Validate correct answer
            |--------------------------------------------------------------------------
            */

            $correctAnswer = strtoupper(
                trim((string) $row['correct_ans'])
            );


            if (!in_array(
                $correctAnswer,
                ['A', 'B', 'C', 'D'],
                true
            )) {

                $excelRow = $index + 2;

                throw new \Exception(
                    'Invalid correct_ans on Excel row '
                    . $excelRow
                    . '. Allowed values are A, B, C or D.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Generate unique question ID
            |--------------------------------------------------------------------------
            |
            | The admin does NOT provide question_id.
            |
            | Laravel generates a 32-character hexadecimal hash.
            |
            */

            do {

                $questionId = md5(
                    uniqid(
                        (string) Str::uuid(),
                        true
                    )
                );

            } while (
                Question::where(
                    'question_id',
                    $questionId
                )->exists()
            );


            /*
            |--------------------------------------------------------------------------
            | Create question
            |--------------------------------------------------------------------------
            */

            Question::create([

                'exam_id' =>
                    $this->examId,

                'question_id' =>
                    $questionId,

                'question_statement' =>
                    trim(
                        (string) $row['question_statement']
                    ),

                'ans_a' =>
                    trim(
                        (string) $row['ans_a']
                    ),

                'ans_b' =>
                    trim(
                        (string) $row['ans_b']
                    ),

                'ans_c' =>
                    trim(
                        (string) $row['ans_c']
                    ),

                'ans_d' =>
                    trim(
                        (string) $row['ans_d']
                    ),

                'correct_ans' =>
                    $correctAnswer,

            ]);
        }
    }
}
