@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Available Exams
        </h1>

        <p class="text-muted">
            Select an examination to view its details.
        </p>

    </div>


    <div class="row g-4">

        @forelse($exams as $exam)

            <div class="col-md-6 col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between
                                    align-items-start
                                    mb-3">

                            <div>

                                <span class="badge bg-primary">

                                    {{ $exam->bps_scale }}

                                </span>

                            </div>

                            <span class="text-muted">

                                {{ $exam->year }}

                            </span>

                        </div>


                        <h5 class="card-title">

                            {{ $exam->post_name }}

                        </h5>


                        <p class="text-muted mb-2">

                            {{ $exam->department }}

                        </p>


                        <p class="mb-3">

                            <strong>
                                Subject:
                            </strong>

                            {{ $exam->subject }}

                        </p>


                        <div class="mb-3">

                            <i class="bi bi-question-circle"></i>

                            {{ $exam->questions_count }}

                            Questions

                        </div>


                        <a
                            href="{{ route('user.exams.show', $exam->id) }}"
                            class="btn btn-primary w-100">

                            <i class="bi bi-play-circle me-1"></i>

                            View Exam

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-journal-x fs-1
                                  text-muted"></i>

                        <h5 class="mt-3">
                            No Exams Available
                        </h5>

                        <p class="text-muted mb-0">

                            There are currently no published
                            examinations available.

                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection