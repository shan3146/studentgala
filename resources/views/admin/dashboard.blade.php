@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Admin Dashboard
            </h1>

            <p class="text-muted mb-0">
                Examination system overview and performance.
            </p>

        </div>

        <div>

            <a href="{{ route('admin.exams.create') }}"
               class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>

                Add Exam

            </a>

        </div>

    </div>


    {{-- =====================================================
         KPI CARDS
    ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- USERS --}}

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Total Users
                            </p>

                            <h2 class="mb-0">
                                {{ number_format($totalUsers) }}
                            </h2>

                        </div>

                        <div class="text-primary fs-2">

                            <i class="bi bi-people"></i>

                        </div>

                    </div>

                    <small class="text-muted">

                        {{ number_format($newUsersThisMonth) }}
                        new this month

                    </small>

                </div>

            </div>

        </div>


        {{-- EXAMS --}}

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Total Exams
                            </p>

                            <h2 class="mb-0">
                                {{ number_format($totalExams) }}
                            </h2>

                        </div>

                        <div class="text-success fs-2">

                            <i class="bi bi-journal-text"></i>

                        </div>

                    </div>

                    <small class="text-muted">

                        {{ $publishedExams }} published
                        ·
                        {{ $draftExams }} draft

                    </small>

                </div>

            </div>

        </div>


        {{-- ATTEMPTS --}}

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Total Attempts
                            </p>

                            <h2 class="mb-0">
                                {{ number_format($totalAttempts) }}
                            </h2>

                        </div>

                        <div class="text-warning fs-2">

                            <i class="bi bi-pencil-square"></i>

                        </div>

                    </div>

                    <small class="text-muted">

                        {{ number_format($completedAttempts) }}
                        completed

                    </small>

                </div>

            </div>

        </div>


        {{-- PASS RATE --}}

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Pass Rate
                            </p>

                            <h2 class="mb-0">
                                {{ $passRate }}%
                            </h2>

                        </div>

                        <div class="text-info fs-2">

                            <i class="bi bi-graph-up-arrow"></i>

                        </div>

                    </div>

                    <small class="text-muted">

                        Average:
                        {{ $averagePercentage }}%

                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         EXAM / ATTEMPT STATUS
    ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- EXAM STATUS --}}

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Exam Status
                    </h5>

                </div>

                <div class="card-body">


                    <div class="row text-center">


                        <div class="col-4">

                            <div class="fs-3 fw-bold text-primary">

                                {{ $totalExams }}

                            </div>

                            <small class="text-muted">
                                Total
                            </small>

                        </div>


                        <div class="col-4">

                            <div class="fs-3 fw-bold text-success">

                                {{ $publishedExams }}

                            </div>

                            <small class="text-muted">
                                Published
                            </small>

                        </div>


                        <div class="col-4">

                            <div class="fs-3 fw-bold text-warning">

                                {{ $draftExams }}

                            </div>

                            <small class="text-muted">
                                Draft
                            </small>

                        </div>

                    </div>


                    <hr>


                    <div class="progress"
                         style="height: 10px;">

                        @if($totalExams > 0)

                            <div
                                class="progress-bar bg-success"
                                style="
                                    width:
                                    {{ ($publishedExams / $totalExams) * 100 }}%;
                                ">

                            </div>

                            <div
                                class="progress-bar bg-warning"
                                style="
                                    width:
                                    {{ ($draftExams / $totalExams) * 100 }}%;
                                ">

                            </div>

                        @endif

                    </div>


                </div>

            </div>

        </div>


        {{-- ATTEMPT STATUS --}}

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Examination Attempts
                    </h5>

                </div>

                <div class="card-body">


                    <div class="row text-center">


                        <div class="col-3">

                            <div class="fs-4 fw-bold">

                                {{ $totalAttempts }}

                            </div>

                            <small class="text-muted">
                                Total
                            </small>

                        </div>


                        <div class="col-3">

                            <div class="fs-4 fw-bold text-success">

                                {{ $completedAttempts }}

                            </div>

                            <small class="text-muted">
                                Completed
                            </small>

                        </div>


                        <div class="col-3">

                            <div class="fs-4 fw-bold text-warning">

                                {{ $inProgressAttempts }}

                            </div>

                            <small class="text-muted">
                                Active
                            </small>

                        </div>


                        <div class="col-3">

                            <div class="fs-4 fw-bold text-danger">

                                {{ $expiredAttempts }}

                            </div>

                            <small class="text-muted">
                                Expired
                            </small>

                        </div>

                    </div>


                    <hr>


                    <div class="progress"
                         style="height: 10px;">

                        @if($totalAttempts > 0)

                            <div
                                class="progress-bar bg-success"
                                style="
                                    width:
                                    {{ ($completedAttempts / $totalAttempts) * 100 }}%;
                                ">

                            </div>

                            <div
                                class="progress-bar bg-warning"
                                style="
                                    width:
                                    {{ ($inProgressAttempts / $totalAttempts) * 100 }}%;
                                ">

                            </div>

                            <div
                                class="progress-bar bg-danger"
                                style="
                                    width:
                                    {{ ($expiredAttempts / $totalAttempts) * 100 }}%;
                                ">

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PERFORMANCE
    ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- PERFORMANCE SUMMARY --}}

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Performance
                    </h5>

                </div>

                <div class="card-body text-center">


                    <div class="display-5 fw-bold mb-2">

                        {{ $averagePercentage }}%

                    </div>

                    <p class="text-muted">
                        Average Score
                    </p>


                    <div class="row mt-4">


                        <div class="col-6">

                            <div class="text-success fs-4 fw-bold">

                                {{ $passedAttempts }}

                            </div>

                            <small class="text-muted">
                                Passed
                            </small>

                        </div>


                        <div class="col-6">

                            <div class="text-danger fs-4 fw-bold">

                                {{ $failedAttempts }}

                            </div>

                            <small class="text-muted">
                                Failed
                            </small>

                        </div>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between">

                        <span>
                            Pass Rate
                        </span>

                        <strong class="text-success">
                            {{ $passRate }}%
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mt-2">

                        <span>
                            Fail Rate
                        </span>

                        <strong class="text-danger">
                            {{ $failRate }}%
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- PASS / FAIL --}}

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Pass / Fail Distribution
                    </h5>

                </div>

                <div class="card-body">


                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span>
                                Passed
                            </span>

                            <strong>
                                {{ $passRate }}%
                            </strong>

                        </div>


                        <div class="progress"
                             style="height: 20px;">

                            <div
                                class="progress-bar bg-success"
                                style="
                                    width:
                                    {{ $passRate }}%;
                                ">

                            </div>

                        </div>

                    </div>


                    <div>

                        <div class="d-flex justify-content-between mb-2">

                            <span>
                                Failed
                            </span>

                            <strong>
                                {{ $failRate }}%
                            </strong>

                        </div>


                        <div class="progress"
                             style="height: 20px;">

                            <div
                                class="progress-bar bg-danger"
                                style="
                                    width:
                                    {{ $failRate }}%;
                                ">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         RECENT ATTEMPTS
    ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Recent Exam Attempts
            </h5>

            <span class="badge bg-primary">
                Latest 10
            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Candidate
                            </th>

                            <th>
                                Exam
                            </th>

                            <th>
                                Score
                            </th>

                            <th>
                                Percentage
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Submitted
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($recentAttempts as $attempt)

                        @php

                            $percentage =
                                $attempt->total_questions > 0
                                ? round(
                                    (
                                        $attempt->score /
                                        $attempt->total_questions
                                    ) * 100,
                                    2
                                )
                                : 0;

                        @endphp


                        <tr>

                            <td>

                                <strong>

                                    {{ $attempt->user->name ?? 'Unknown' }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ $attempt->user->email ?? '' }}

                                </small>

                            </td>


                            <td>

                                {{ $attempt->exam->post_name
                                    ?? $attempt->exam->name
                                    ?? 'Exam' }}

                            </td>


                            <td>

                                {{ $attempt->score }}

                                /

                                {{ $attempt->total_questions }}

                            </td>


                            <td>

                                {{ $percentage }}%

                            </td>


                            <td>

                                @if($percentage >= 50)

                                    <span class="badge bg-success">

                                        Passed

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Failed

                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($attempt->submitted_at)

                                    {{ $attempt->submitted_at->format(
                                        'd M Y, h:i A'
                                    ) }}

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                No completed examinations yet.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection