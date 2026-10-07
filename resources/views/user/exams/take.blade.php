@extends('layouts.app')

@section('title', 'Examination')

@section('content')

<style>

    body {
        overflow: hidden;
    }

    .exam-wrapper {
        height: calc(100vh - 70px);
        overflow: hidden;
    }

    .exam-question-area {
        height: 100%;
        overflow-y: auto;
    }

    .exam-sidebar {
        height: 100%;
        overflow-y: auto;
    }

    .option-label {
        display: block;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: 0.2s;
    }

    .option-label:hover {
        background: #f8f9fa;
    }

    .option-label.selected {
        border-color: #0d6efd;
        background: #eaf2ff;
    }

    .question-number {
        width: 42px;
        height: 42px;
        margin: 4px;
    }

</style>


<div class="container-fluid exam-wrapper">

    <div class="row h-100">


        {{-- =====================================================
             QUESTION AREA
        ====================================================== --}}

        <div class="col-lg-9 exam-question-area p-4">

            <div class="d-flex justify-content-between
                        align-items-center mb-4">

                <div>

                    <h4 class="mb-1">
                        {{ $attempt->exam->subject }}
                    </h4>

                    <small class="text-muted">
                        {{ $attempt->exam->post_name }}
                    </small>

                </div>


                {{-- TIMER --}}

                <div class="text-center">

                    <small class="text-muted d-block">
                        Time Remaining
                    </small>

                    <div
                        id="examTimer"
                        class="fs-3 fw-bold text-danger">

                        Loading...

                    </div>

                </div>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">


                    <div class="d-flex
                                justify-content-between
                                mb-4">

                        <h5 class="mb-0">

                            Question
                            <span id="currentQuestionNumber">
                                1
                            </span>

                            of

                            {{ $attempt->exam->questions->count() }}

                        </h5>

                    </div>


                    {{-- QUESTIONS --}}

                    @foreach(
                        $attempt->exam->questions
                        as $index => $question
                    )

                        <div
                            class="question-container"
                            data-question-index="{{ $index }}"
                            data-question-id="{{ $question->id }}"
                            style="{{ $index === 0
                                ? ''
                                : 'display:none;' }}">

                            <div class="mb-4">

                                <h5>
                                    {{ $question->question_statement }}
                                </h5>

                            </div>


                            {{-- A --}}

                            <label
                                class="option-label">

                                <input
                                    type="radio"
                                    name="question_{{ $question->id }}"
                                    value="A"
                                    class="answer-option me-2"
                                    data-question-id="{{ $question->id }}">

                                <strong>A.</strong>

                                {{ $question->ans_a }}

                            </label>


                            {{-- B --}}

                            <label
                                class="option-label">

                                <input
                                    type="radio"
                                    name="question_{{ $question->id }}"
                                    value="B"
                                    class="answer-option me-2"
                                    data-question-id="{{ $question->id }}">

                                <strong>B.</strong>

                                {{ $question->ans_b }}

                            </label>


                            {{-- C --}}

                            <label
                                class="option-label">

                                <input
                                    type="radio"
                                    name="question_{{ $question->id }}"
                                    value="C"
                                    class="answer-option me-2"
                                    data-question-id="{{ $question->id }}">

                                <strong>C.</strong>

                                {{ $question->ans_c }}

                            </label>


                            {{-- D --}}

                            <label
                                class="option-label">

                                <input
                                    type="radio"
                                    name="question_{{ $question->id }}"
                                    value="D"
                                    class="answer-option me-2"
                                    data-question-id="{{ $question->id }}">

                                <strong>D.</strong>

                                {{ $question->ans_d }}

                            </label>

                        </div>

                    @endforeach


                    {{-- NAVIGATION --}}

                    <div class="d-flex
                                justify-content-between
                                mt-4">

                        <button
                            type="button"
                            id="previousButton"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left"></i>

                            Previous

                        </button>


                        <button
                            type="button"
                            id="nextButton"
                            class="btn btn-primary">

                            Next

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             QUESTION PALETTE
        ====================================================== --}}

        <div class="col-lg-3
                    exam-sidebar
                    border-start
                    bg-light
                    p-3">

            <h6 class="mb-3">
                Questions
            </h6>


            <div class="d-flex flex-wrap">

                @foreach(
                    $attempt->exam->questions
                    as $index => $question
                )

                    <button
                        type="button"
                        class="btn btn-outline-secondary
                               question-number"
                        data-index="{{ $index }}">

                        {{ $index + 1 }}

                    </button>

                @endforeach

            </div>


            <hr>


            <button
                type="button"
                id="submitExamButton"
                class="btn btn-danger w-100">

                <i class="bi bi-send me-1"></i>

                Submit Exam

            </button>

        </div>

    </div>

</div>


{{-- =====================================================
     SUBMIT FORM
====================================================== --}}

<form
    method="POST"
    action="{{ route(
        'user.exams.submit',
        $attempt->id
    ) }}"
    id="submitExamForm">

    @csrf

</form>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const questions =
            document.querySelectorAll(
                '.question-container'
            );

        const questionButtons =
            document.querySelectorAll(
                '.question-number'
            );

        const previousButton =
            document.getElementById(
                'previousButton'
            );

        const nextButton =
            document.getElementById(
                'nextButton'
            );

        const timerElement =
            document.getElementById(
                'examTimer'
            );

        const submitButton =
            document.getElementById(
                'submitExamButton'
            );

        const submitForm =
            document.getElementById(
                'submitExamForm'
            );


        let currentIndex = 0;


        /*
         * Server-generated expiry timestamp.
         */
        const expiresAt =
            new Date(
                "{{ $attempt->expires_at->toIso8601String() }}"
            ).getTime();


        /*
         * Show question.
         */
        function showQuestion(index)
        {
            if (
                index < 0 ||
                index >= questions.length
            ) {
                return;
            }

            questions.forEach(
                function (question) {

                    question.style.display =
                        'none';

                }
            );


            questions[index].style.display =
                'block';


            currentIndex = index;


            document.getElementById(
                'currentQuestionNumber'
            ).innerText =
                index + 1;


            questionButtons.forEach(
                function (button, buttonIndex) {

                    button.classList.toggle(
                        'btn-primary',
                        buttonIndex === index
                    );

                    button.classList.toggle(
                        'btn-outline-secondary',
                        buttonIndex !== index
                    );

                }
            );


            previousButton.disabled =
                index === 0;


            nextButton.disabled =
                index ===
                questions.length - 1;
        }


        /*
         * Previous.
         */
        previousButton.addEventListener(
            'click',
            function () {

                showQuestion(
                    currentIndex - 1
                );

            }
        );


        /*
         * Next.
         */
        nextButton.addEventListener(
            'click',
            function () {

                showQuestion(
                    currentIndex + 1
                );

            }
        );


        /*
         * Question palette.
         */
        questionButtons.forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        showQuestion(
                            Number(
                                this.dataset.index
                            )
                        );

                    }
                );

            }
        );


        /*
         * Save answer.
         */
        document.querySelectorAll(
            '.answer-option'
        ).forEach(
            function (radio) {

                radio.addEventListener(
                    'change',
                    function () {

                        const questionId =
                            this.dataset.questionId;

                        const selectedOption =
                            this.value;


                        fetch(
                            "{{ route(
                                'user.exams.answer',
                                $attempt->id
                            ) }}",
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        "{{ csrf_token() }}",

                                    'Accept':
                                        'application/json'
                                },

                                body: JSON.stringify({

                                    question_id:
                                        questionId,

                                    selected_option:
                                        selectedOption

                                })
                            }
                        );

                    }
                );

            }
        );


        /*
         * Timer.
         */
        function updateTimer()
        {
            const now =
                new Date().getTime();

            let remaining =
                Math.floor(
                    (expiresAt - now) / 1000
                );


            if (remaining <= 0) {

                timerElement.innerText =
                    '00:00:00';

                submitForm.submit();

                return;

            }


            const hours =
                Math.floor(
                    remaining / 3600
                );

            remaining %= 3600;


            const minutes =
                Math.floor(
                    remaining / 60
                );

            const seconds =
                remaining % 60;


            timerElement.innerText =
                String(hours).padStart(2, '0')
                + ':'
                + String(minutes).padStart(2, '0')
                + ':'
                + String(seconds).padStart(2, '0');
        }


        updateTimer();

        setInterval(
            updateTimer,
            1000
        );


        /*
         * Submit confirmation.
         */
        submitButton.addEventListener(
            'click',
            function () {

                const confirmed =
                    confirm(
                        'Are you sure you want to submit the examination?'
                    );

                if (confirmed) {

                    submitForm.submit();

                }

            }
        );


        /*
         * Initial question.
         */
        showQuestion(0);

    }
);

</script>

@endsection