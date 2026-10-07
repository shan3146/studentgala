@extends('layouts.app')

@section('title', 'Attempted Exams')

@section('content')

{{-- =====================================================
     ATTEMPTED EXAMS
====================================================== --}}

<div id="attempted"
     class="dashboard-section"
     style="display:none;">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Attempted Exams
        </h1>

        <p class="text-muted">
            View the exams you have already attempted and your performance.
        </p>

    </div>


    @if($attempts->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-journal-x fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No Attempted Exams
                </h5>

                <p class="text-muted mb-0">
                    You have not attempted any exams yet.
                </p>

            </div>

        </div>

    @else

        <div class="row g-4">

            @foreach($attempts as $attempt)

                <div class="col-md-6 col-xl-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h5 class="mb-0">
                                    {{ $attempt->exam->subject ?? 'Exam' }}
                                </h5>

                                <span class="badge bg-success">
                                    Attempted
                                </span>

                            </div>


                            <p class="text-muted mb-1">
                                <strong>Department:</strong>
                                {{ $attempt->exam->department ?? '-' }}
                            </p>

                            <p class="text-muted mb-1">
                                <strong>Post:</strong>
                                {{ $attempt->exam->post_name ?? '-' }}
                            </p>

                            <p class="text-muted mb-3">
                                <strong>Year:</strong>
                                {{ $attempt->exam->year ?? '-' }}
                            </p>


                            <hr>


                            <div class="row text-center">

                                <div class="col-6">

                                    <small class="text-muted">
                                        Score
                                    </small>

                                    <h4 class="mb-0">

                                        {{ $attempt->score }}
                                        /
                                        {{ $attempt->total_questions }}

                                    </h4>

                                </div>


                                <div class="col-6">

                                    <small class="text-muted">
                                        Percentage
                                    </small>

                                    @php

                                        $percentage =
                                            $attempt->total_questions > 0
                                            ? (
                                                $attempt->score /
                                                $attempt->total_questions
                                            ) * 100
                                            : 0;

                                    @endphp

                                    <h4 class="mb-0">

                                        {{ number_format($percentage, 1) }}%

                                    </h4>

                                </div>

                            </div>


                            <div class="mt-4">

                                <a
                                    href="{{ route(
                                        'user.exams.result',
                                        $attempt->id
                                    ) }}"
                                    class="btn btn-primary w-100">

                                    <i class="bi bi-bar-chart me-1"></i>

                                    View Result

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection