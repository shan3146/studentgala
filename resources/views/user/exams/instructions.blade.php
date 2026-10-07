@extends('layouts.app')

@section('title', 'Exam Instructions')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white p-4">

                    <h2 class="mb-1">
                        Examination Instructions
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $exam->subject }}
                    </p>

                </div>


                <div class="card-body p-4">


                    <div class="alert alert-warning">

                        <strong>
                            Important:
                        </strong>

                        Once you start the examination,
                        the timer cannot be paused.

                    </div>


                    <h5 class="mb-3">
                        Examination Summary
                    </h5>


                    <div class="row g-3 mb-4">

                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Questions
                                </small>

                                <h4 class="mb-0">
                                    {{ $exam->questions_count }}
                                </h4>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Time
                                </small>

                                <h4 class="mb-0">
                                    {{ $totalMinutes }} min
                                </h4>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <small class="text-muted">
                                    Per Question
                                </small>

                                <h4 class="mb-0">
                                    {{ $secondsPerQuestion }} sec
                                </h4>

                            </div>

                        </div>

                    </div>


                    <h5 class="mb-3">
                        Rules
                    </h5>


                    <ul class="list-group mb-4">

                        <li class="list-group-item">

                            <i class="bi bi-clock me-2"></i>

                            The examination has a fixed time limit.

                        </li>


                        <li class="list-group-item">

                            <i class="bi bi-save me-2"></i>

                            Your answers will be saved while
                            you progress through the exam.

                        </li>


                        <li class="list-group-item">

                            <i class="bi bi-send me-2"></i>

                            The examination will automatically
                            submit when the time expires.

                        </li>


                        <li class="list-group-item">

                            <i class="bi bi-window me-2"></i>

                            Do not close or refresh the examination
                            window.

                        </li>


                        <li class="list-group-item">

                            <i class="bi bi-box-arrow-up-right me-2"></i>

                            Avoid switching browser tabs or windows.

                        </li>


                        @if($exam->negative_marking)

                            <li class="list-group-item text-danger">

                                <i class="bi bi-dash-circle me-2"></i>

                                Negative marking is enabled.

                            </li>

                        @else

                            <li class="list-group-item text-success">

                                <i class="bi bi-check-circle me-2"></i>

                                There is no negative marking.

                            </li>

                        @endif

                    </ul>


                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="confirmInstructions">

                        <label
                            class="form-check-label"
                            for="confirmInstructions">

                            I have read and understood all
                            examination instructions.

                        </label>

                    </div>


                    <div class="d-flex justify-content-between">

                        <a
                            href="{{ route(
                                'user.exams.show',
                                $exam->id
                            ) }}"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back

                        </a>


                        <form
                            method="POST"
                            action="{{ route(
                                'user.exams.start',
                                $exam->id
                            ) }}"
                            id="startExamForm">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success"
                                id="startExamButton"
                                disabled>

                                <i class="bi bi-play-fill me-1"></i>

                                Start Examination

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const checkbox =
            document.getElementById(
                'confirmInstructions'
            );

        const button =
            document.getElementById(
                'startExamButton'
            );

        checkbox.addEventListener(
            'change',
            function () {

                button.disabled =
                    !this.checked;

            }
        );

    }
);

</script>

@endsection