@extends('layouts.app')

@section('title', 'Exam Details')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white p-4">

                    <h2 class="mb-1">
                        {{ $exam->subject }}
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $exam->post_name }}
                    </p>

                </div>


                <div class="card-body p-4">

                    <div class="row g-4">


                        <div class="col-md-6">

                            <small class="text-muted">
                                Department
                            </small>

                            <div class="fw-semibold">
                                {{ $exam->department }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Post
                            </small>

                            <div class="fw-semibold">
                                {{ $exam->post_name }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                BPS Scale
                            </small>

                            <div class="fw-semibold">
                                {{ $exam->bps_scale }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Year
                            </small>

                            <div class="fw-semibold">
                                {{ $exam->year }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Total Questions
                            </small>

                            <div class="fw-semibold">
                                {{ $exam->questions_count }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Time Per Question
                            </small>

                            <div class="fw-semibold">
                                {{ $secondsPerQuestion }} seconds
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Total Time
                            </small>

                            <div class="fw-semibold">

                                {{ $totalMinutes }} minutes

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Negative Marking
                            </small>

                            <div>

                                @if($exam->negative_marking)

                                    <span class="badge bg-danger">
                                        Yes
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        No
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    <hr class="my-4">


                    <div class="alert alert-info">

                        <i class="bi bi-info-circle me-2"></i>

                        Please read the examination instructions
                        carefully before starting.

                    </div>


                    <div class="d-flex justify-content-between">

                        <a
                            href="{{ route('user.exams.index') }}"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back

                        </a>


                        <a
                            href="{{ route(
                                'user.exams.instructions',
                                $exam->id
                            ) }}"
                            class="btn btn-primary">

                            Continue

                            <i class="bi bi-arrow-right ms-1"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection