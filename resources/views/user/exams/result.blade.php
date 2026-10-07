@extends('layouts.app')

@section('title', 'Exam Result')

@section('content')

<div class="container-fluid">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Examination Report
            </h1>

            <p class="text-muted mb-0">
                Complete examination result
            </p>

        </div>


        <a
            href="{{ route('user.exams.index') }}"
            class="btn btn-outline-primary">

            <i class="bi bi-arrow-left me-1"></i>

            Back to Exams

        </a>

    </div>


    {{-- =====================================================
         RESULT STATUS
    ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body text-center p-5">

            @if($passed)

                <div class="text-success">

                    <i class="bi bi-check-circle-fill"
                       style="font-size: 60px;">
                    </i>

                    <h2 class="mt-3">
                        Congratulations!
                    </h2>

                    <h4>
                        PASS
                    </h4>

                </div>

            @else

                <div class="text-danger">

                    <i class="bi bi-x-circle-fill"
                       style="font-size: 60px;">
                    </i>

                    <h2 class="mt-3">
                        Examination Completed
                    </h2>

                    <h4>
                        NOT PASSED
                    </h4>

                </div>

            @endif


            <div class="mt-4">

                <span class="display-4 fw-bold">

                    {{ number_format($score, 2) }}

                </span>

                <span class="text-muted fs-5">

                    / {{ $totalMarks }}

                </span>

            </div>


            <p class="text-muted mb-0">

                {{ number_format($percentage, 2) }}%

            </p>

        </div>

    </div>


    {{-- =====================================================
         EXAM INFORMATION
    ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Examination Information
            </h5>

        </div>


        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4">

                    <small class="text-muted">
                        Candidate
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->user->name }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Email
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->user->email }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Subject
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->exam->subject }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Department
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->exam->department }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Post
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->exam->post_name }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Year
                    </small>

                    <div class="fw-semibold">

                        {{ $attempt->exam->year }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Started At
                    </small>

                    <div class="fw-semibold">

                        {{ optional($attempt->started_at)
                            ->format('d M Y, h:i A') }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Submitted At
                    </small>

                    <div class="fw-semibold">

                        {{ optional($attempt->submitted_at)
                            ->format('d M Y, h:i A') }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Time Taken
                    </small>

                    <div class="fw-semibold">

                        {{ $timeTaken }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PERFORMANCE SUMMARY
    ====================================================== --}}

    <div class="row g-4 mb-4">


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="text-primary fs-2">

                        <i class="bi bi-list-ol"></i>

                    </div>

                    <div class="text-muted">
                        Total Questions
                    </div>

                    <h3>
                        {{ $totalQuestions }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="text-info fs-2">

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <div class="text-muted">
                        Attempted
                    </div>

                    <h3>
                        {{ $attempted }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="text-success fs-2">

                        <i class="bi bi-check-circle"></i>

                    </div>

                    <div class="text-muted">
                        Correct
                    </div>

                    <h3>
                        {{ $correct }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <div class="text-danger fs-2">

                        <i class="bi bi-x-circle"></i>

                    </div>

                    <div class="text-muted">
                        Wrong
                    </div>

                    <h3>
                        {{ $wrong }}
                    </h3>

                </div>

            </div>

        </div>


    </div>


    {{-- =====================================================
         UNANSWERED / SCORE
    ====================================================== --}}

    <div class="row g-4 mb-4">


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <div class="text-secondary fs-2">

                        <i class="bi bi-dash-circle"></i>

                    </div>

                    <div class="text-muted">
                        Unanswered
                    </div>

                    <h3>
                        {{ $unanswered }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <div class="text-warning fs-2">

                        <i class="bi bi-award"></i>

                    </div>

                    <div class="text-muted">
                        Score
                    </div>

                    <h3>

                        {{ number_format($score, 2) }}

                        /
                        {{ $totalMarks }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <div class="text-primary fs-2">

                        <i class="bi bi-percent"></i>

                    </div>

                    <div class="text-muted">
                        Percentage
                    </div>

                    <h3>
                        {{ number_format(
                            $percentage,
                            2
                        ) }}%
                    </h3>

                </div>

            </div>

        </div>


    </div>


    {{-- =====================================================
         QUESTION REVIEW
    ====================================================== --}}

    <div class="card border-0 shadow-sm mb-5">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                Question Review

            </h5>

        </div>


        <div class="card-body p-0">

            @foreach(
                $attempt->exam->questions
                as $index => $question
            )

                @php

                    $answer =
                        $attempt->answers
                            ->where(
                                'question_id',
                                $question->id
                            )
                            ->first();

                @endphp


                <div class="p-4 border-bottom">


                    <div class="d-flex
                                justify-content-between
                                align-items-start
                                mb-3">

                        <h6 class="mb-0">

                            Question
                            {{ $index + 1 }}

                        </h6>


                        @if(!$answer)

                            <span class="badge bg-secondary">

                                Unanswered

                            </span>

                        @elseif($answer->is_correct)

                            <span class="badge bg-success">

                                Correct

                            </span>

                        @else

                            <span class="badge bg-danger">

                                Wrong

                            </span>

                        @endif

                    </div>


                    <div class="mb-3">

                        <strong>
                            {{ $question->question_statement }}
                        </strong>

                    </div>


                    <div class="row g-3">


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Your Answer
                                </small>

                                <div class="fw-semibold">

                                    @if(
                                        $answer &&
                                        $answer->selected_option
                                    )

                                        {{ $answer->selected_option }}

                                    @else

                                        <span
                                            class="text-muted">

                                            Not Answered

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Correct Answer
                                </small>

                                <div class="fw-semibold text-success">

                                    {{ $question->correct_ans }}

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Marks Awarded
                                </small>

                                <div class="fw-semibold">

                                    @if($answer)

                                        {{ number_format(
                                            $answer->marks_awarded,
                                            2
                                        ) }}

                                    @else

                                        0.00

                                    @endif

                                </div>

                            </div>

                        </div>


                    </div>


                    {{-- OPTIONS --}}

                    <div class="mt-3">

                        <div>
                            <strong>A.</strong>
                            {{ $question->ans_a }}
                        </div>

                        <div>
                            <strong>B.</strong>
                            {{ $question->ans_b }}
                        </div>

                        <div>
                            <strong>C.</strong>
                            {{ $question->ans_c }}
                        </div>

                        <div>
                            <strong>D.</strong>
                            {{ $question->ans_d }}
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection