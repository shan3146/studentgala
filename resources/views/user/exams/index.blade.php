@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')

<div class="container-fluid">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Available Exams
            </h1>

            <p class="text-muted mb-0">
                Browse examinations by year, department and post.
            </p>

        </div>

        <a
            href="{{ route('user.exams.attempted') }}"
            class="btn btn-outline-primary">

            <i class="bi bi-clock-history me-1"></i>

            Attempted Exams

        </a>

    </div>


    {{-- =====================================================
         NO EXAMS
    ====================================================== --}}

    @if($exams->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div class="mb-3">

                    <i
                        class="bi bi-journal-x text-muted"
                        style="font-size: 60px;">
                    </i>

                </div>

                <h5>
                    No Exams Available
                </h5>

                <p class="text-muted mb-0">

                    There are currently no published exams
                    available.

                </p>

            </div>

        </div>

    @else


        {{-- =================================================
             GROUP EXAMS BY YEAR
        ================================================== --}}

        @php

            $groupedExams = $exams->groupBy('year');

        @endphp


        @foreach($groupedExams as $year => $yearExams)

            {{-- =================================================
                 YEAR
            ================================================== --}}

            <div class="mb-4">

                <div class="d-flex align-items-center mb-3">

                    <div
                        class="bg-primary text-white rounded-circle
                               d-flex align-items-center justify-content-center
                               me-2"
                        style="width:40px;height:40px;">

                        <i class="bi bi-calendar3"></i>

                    </div>

                    <div>

                        <h4 class="mb-0">
                            {{ $year }}
                        </h4>

                        <small class="text-muted">
                            {{ $yearExams->count() }}
                            {{ $yearExams->count() == 1 ? 'Exam' : 'Exams' }}
                        </small>

                    </div>

                </div>


                {{-- =================================================
                     GROUP BY DEPARTMENT
                ================================================== --}}

                @php

                    $departments =
                        $yearExams->groupBy('department');

                @endphp


                @foreach($departments as $department => $departmentExams)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header bg-white border-0 py-3">

                            <div class="d-flex align-items-center">

                                <i
                                    class="bi bi-building
                                           text-primary me-2"
                                    style="font-size:20px;">
                                </i>

                                <div>

                                    <h5 class="mb-0">
                                        {{ $department }}
                                    </h5>

                                    <small class="text-muted">

                                        {{ $departmentExams->count() }}

                                        {{ $departmentExams->count() == 1
                                            ? 'Post'
                                            : 'Posts' }}

                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="card-body">

                            {{-- =================================================
                                 GROUP BY POST
                            ================================================== --}}

                            @php

                                $posts =
                                    $departmentExams->groupBy('post_name');

                            @endphp


                            @foreach($posts as $postName => $postExams)

                                <div class="mb-4">

                                    {{-- POST HEADER --}}

                                    <div
                                        class="d-flex align-items-center
                                               mb-3">

                                        <div
                                            class="me-2 text-secondary">

                                            <i
                                                class="bi bi-person-badge"
                                                style="font-size:20px;">
                                            </i>

                                        </div>

                                        <div>

                                            <h6 class="mb-0">

                                                {{ $postName }}

                                            </h6>

                                            <small class="text-muted">

                                                {{ $postExams->count() }}

                                                {{ $postExams->count() == 1
                                                    ? 'Exam'
                                                    : 'Exams' }}

                                            </small>

                                        </div>

                                    </div>


                                    {{-- =================================================
                                         EXAMS
                                    ================================================== --}}

                                    <div class="row g-3">

                                        @foreach($postExams as $exam)

                                            @php

                                                /*
                                                 * Check whether this user
                                                 * has already completed
                                                 * this exam.
                                                 */

                                                $attempt =
                                                    $attempts[$exam->id]
                                                    ?? null;


                                                /*
                                                 * Number of questions
                                                 */

                                                $questionCount =
                                                    $exam->questions_count
                                                    ?? 0;


                                                /*
                                                 * 75 seconds per question
                                                 */

                                                $totalSeconds =
                                                    $questionCount * 75;


                                                /*
                                                 * Convert seconds to
                                                 * hours/minutes.
                                                 */

                                                $hours =
                                                    floor(
                                                        $totalSeconds / 3600
                                                    );

                                                $minutes =
                                                    floor(
                                                        ($totalSeconds % 3600)
                                                        / 60
                                                    );


                                                /*
                                                 * Display time
                                                 */

                                                if ($hours > 0) {

                                                    $examTime =
                                                        $hours . ' hr ' .
                                                        $minutes . ' min';

                                                } else {

                                                    $examTime =
                                                        $minutes . ' min';

                                                }

                                            @endphp


                                            <div class="col-12 col-md-6 col-xl-4">

                                                <div
                                                    class="card
                                                           border-0
                                                           shadow-sm
                                                           h-100">


                                                    <div class="card-body d-flex flex-column">


                                                        {{-- =============================================
                                                             EXAM STATUS
                                                        ============================================== --}}

                                                        <div
                                                            class="d-flex
                                                                   justify-content-between
                                                                   align-items-center
                                                                   mb-3">

                                                            <span
                                                                class="badge
                                                                bg-light
                                                                text-dark">

                                                                {{ $exam->year }}

                                                            </span>


                                                            @if($attempt)

                                                                <span
                                                                    class="badge
                                                                           bg-success">

                                                                    <i
                                                                        class="bi
                                                                               bi-check-circle
                                                                               me-1">
                                                                    </i>

                                                                    Attempted

                                                                </span>

                                                            @else

                                                                <span
                                                                    class="badge
                                                                           bg-primary">

                                                                    Available

                                                                </span>

                                                            @endif

                                                        </div>


                                                        {{-- =============================================
                                                             SUBJECT
                                                        ============================================== --}}

                                                        <h5 class="card-title mb-2">

                                                            {{ $exam->subject }}

                                                        </h5>


                                                        {{-- =============================================
                                                             POST
                                                        ============================================== --}}

                                                        <div class="mb-2">

                                                            <small class="text-muted">

                                                                <i
                                                                    class="bi
                                                                           bi-person-badge
                                                                           me-1">
                                                                </i>

                                                                Post

                                                            </small>

                                                            <div class="fw-semibold">

                                                                {{ $exam->post_name }}

                                                            </div>

                                                        </div>


                                                        {{-- =============================================
                                                             BPS
                                                        ============================================== --}}

                                                        <div class="mb-2">

                                                            <small class="text-muted">

                                                                <i
                                                                    class="bi
                                                                           bi-bar-chart
                                                                           me-1">
                                                                </i>

                                                                BPS Scale

                                                            </small>

                                                            <div class="fw-semibold">

                                                                {{ $exam->bps_scale ?? '-' }}

                                                            </div>

                                                        </div>


                                                        {{-- =============================================
                                                             QUESTIONS
                                                        ============================================== --}}

                                                        <div class="mb-2">

                                                            <small class="text-muted">

                                                                <i
                                                                    class="bi
                                                                           bi-question-circle
                                                                           me-1">
                                                                </i>

                                                                Questions

                                                            </small>

                                                            <div class="fw-semibold">

                                                                {{ $questionCount }}

                                                            </div>

                                                        </div>


                                                        {{-- =============================================
                                                             TIME
                                                        ============================================== --}}

                                                        <div class="mb-3">

                                                            <small class="text-muted">

                                                                <i
                                                                    class="bi
                                                                           bi-clock
                                                                           me-1">
                                                                </i>

                                                                Exam Time

                                                            </small>

                                                            <div class="fw-semibold">

                                                                {{ $examTime }}

                                                            </div>

                                                            <small class="text-muted">

                                                                75 seconds per question

                                                            </small>

                                                        </div>


                                                        <div class="mt-auto">


                                                            {{-- =========================================
                                                                 ALREADY ATTEMPTED
                                                            ========================================== --}}

                                                            @if($attempt)

                                                                <div
                                                                    class="alert
                                                                           alert-success
                                                                           py-2
                                                                           mb-2">

                                                                    <i
                                                                        class="bi
                                                                               bi-check-circle
                                                                               me-1">
                                                                    </i>

                                                                    You have already
                                                                    attempted this exam.

                                                                </div>


                                                                <a
                                                                    href="{{ route(
                                                                        'user.exams.result',
                                                                        $attempt->id
                                                                    ) }}"
                                                                    class="btn
                                                                           btn-primary
                                                                           w-100">

                                                                    <i
                                                                        class="bi
                                                                               bi-bar-chart
                                                                               me-1">
                                                                    </i>

                                                                    View Result

                                                                </a>


                                                            {{-- =========================================
                                                                 NOT ATTEMPTED
                                                            ========================================== --}}

                                                            @else

                                                                <a
                                                                    href="{{ route(
                                                                        'user.exams.instructions',
                                                                        $exam->id
                                                                    ) }}"
                                                                    class="btn
                                                                           btn-primary
                                                                           w-100">

                                                                    <i
                                                                        class="bi
                                                                               bi-play-circle
                                                                               me-1">
                                                                    </i>

                                                                    Start Exam

                                                                </a>

                                                            @endif

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

    @endif

</div>

@endsection