@extends('layouts.admin')

@section('title', 'Exam Preview')

@section('content')

<div class="container-fluid">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Exam Preview
            </h1>

            <p class="text-muted mb-0">
                Preview examination details and questions.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.exams.index') }}"
                class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back to Exams

            </a>

        </div>

    </div>


    {{-- =====================================================
         EXAM INFORMATION
    ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Examination Information
                </h5>


                @if($exam->status === 'published')

                    <span class="badge bg-success">
                        Published
                    </span>

                @else

                    <span class="badge bg-secondary">
                        Draft
                    </span>

                @endif

            </div>

        </div>


        <div class="card-body">

            <div class="row g-4">


                {{-- Advertisement No. --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Advertisement No.
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->advertisement_no ?? 'Not specified' }}

                    </div>

                </div>


                {{-- Department --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Department
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->department }}

                    </div>

                </div>


                {{-- Post --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Post Name
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->post_name }}

                    </div>

                </div>


                {{-- BPS --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        BPS Scale
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->bps_scale }}

                    </div>

                </div>


                {{-- Year --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Year
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->year }}

                    </div>

                </div>


                {{-- Subject --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Subject
                    </div>

                    <div class="fw-semibold">

                        {{ $exam->subject }}

                    </div>

                </div>


                {{-- Questions --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Total Questions
                    </div>

                    <div class="fw-semibold fs-5">

                        {{ $exam->questions->count() }}

                    </div>

                </div>


                {{-- Time Per MCQ --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Time Per MCQ
                    </div>

                    <div class="fw-semibold fs-5">

                        {{ $exam->seconds_per_question ?? 75 }}

                        seconds

                    </div>

                </div>


                {{-- Total Time --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Total Exam Time
                    </div>

                    <div class="fw-semibold fs-5">

                        @php

                            $totalSeconds =
                                $exam->questions->count()
                                *
                                ($exam->seconds_per_question ?? 75);

                            $hours =
                                floor($totalSeconds / 3600);

                            $minutes =
                                floor(
                                    ($totalSeconds % 3600) / 60
                                );

                            $seconds =
                                $totalSeconds % 60;

                        @endphp


                        @if($hours > 0)

                            {{ $hours }}h

                        @endif

                        {{ $minutes }}m

                        @if($seconds > 0)

                            {{ $seconds }}s

                        @endif

                    </div>

                </div>


                {{-- Attempts --}}

                <div class="col-md-4">

                    <div class="text-muted small">
                        Total Attempts
                    </div>

                    <div class="fw-semibold fs-5">

                        {{ $exam->attempts()->count() }}

                    </div>

                </div>


            </div>

        </div>

    </div>


    {{-- =====================================================
         QUESTIONS
    ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Questions
                </h5>

                <span class="badge bg-primary">

                    {{ $exam->questions->count() }}

                    Questions

                </span>

            </div>

        </div>


        <div class="card-body">


            @forelse($exam->questions as $index => $question)

                <div
                    class="border rounded p-4 mb-4">

                    {{-- Question Header --}}

                    <div
                        class="d-flex justify-content-between align-items-start mb-3">

                        <h6 class="mb-0">

                            Question {{ $index + 1 }}

                        </h6>

                        @if($question->question_id)

                            <span class="text-muted small">

                                ID:
                                {{ $question->question_id }}

                            </span>

                        @endif

                    </div>


                    {{-- Question Text --}}

                    <div class="mb-4">

                        <div class="fw-semibold">

                            {!! nl2br(
                                e($question->question_statement)
                            ) !!}

                        </div>

                    </div>


                    {{-- Options --}}

                    <div class="row g-3">


                        {{-- A --}}

                        <div class="col-md-6">

                            <div
                                class="p-3 border rounded
                                {{ strtoupper(trim($question->correct_ans)) === 'A'
                                    ? 'border-success bg-success-subtle'
                                    : '' }}">

                                <strong>A.</strong>

                                {{ $question->ans_a }}

                                @if(
                                    strtoupper(
                                        trim($question->correct_ans)
                                    ) === 'A'
                                )

                                    <span
                                        class="badge bg-success float-end">

                                        Correct

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- B --}}

                        <div class="col-md-6">

                            <div
                                class="p-3 border rounded
                                {{ strtoupper(trim($question->correct_ans)) === 'B'
                                    ? 'border-success bg-success-subtle'
                                    : '' }}">

                                <strong>B.</strong>

                                {{ $question->ans_b }}

                                @if(
                                    strtoupper(
                                        trim($question->correct_ans)
                                    ) === 'B'
                                )

                                    <span
                                        class="badge bg-success float-end">

                                        Correct

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- C --}}

                        <div class="col-md-6">

                            <div
                                class="p-3 border rounded
                                {{ strtoupper(trim($question->correct_ans)) === 'C'
                                    ? 'border-success bg-success-subtle'
                                    : '' }}">

                                <strong>C.</strong>

                                {{ $question->ans_c }}

                                @if(
                                    strtoupper(
                                        trim($question->correct_ans)
                                    ) === 'C'
                                )

                                    <span
                                        class="badge bg-success float-end">

                                        Correct

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- D --}}

                        <div class="col-md-6">

                            <div
                                class="p-3 border rounded
                                {{ strtoupper(trim($question->correct_ans)) === 'D'
                                    ? 'border-success bg-success-subtle'
                                    : '' }}">

                                <strong>D.</strong>

                                {{ $question->ans_d }}

                                @if(
                                    strtoupper(
                                        trim($question->correct_ans)
                                    ) === 'D'
                                )

                                    <span
                                        class="badge bg-success float-end">

                                        Correct

                                    </span>

                                @endif

                            </div>

                        </div>


                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i
                        class="bi bi-question-circle fs-1 text-muted">
                    </i>

                    <h5 class="mt-3">
                        No Questions Found
                    </h5>

                    <p class="text-muted mb-0">
                        This exam does not contain any questions.
                    </p>

                </div>

            @endforelse


        </div>

    </div>

</div>

@endsection