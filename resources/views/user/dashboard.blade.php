@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

{{-- =====================================================
     DASHBOARD
====================================================== --}}

<div id="dashboard" class="dashboard-section">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Dashboard
            </h1>

            <p class="text-muted">
                Welcome back, {{ $user->name }}.
            </p>
        </div>

    </div>


    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Account Status
                    </p>

                    <h4>
                        Active
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Account Type
                    </p>

                    <h4>
                        Normal User
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Member Since
                    </p>

                    <h4>
                        {{ $user->created_at->format('M Y') }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <p class="text-muted mb-1">
                        Profile
                    </p>

                    <h4>
                        Complete
                    </h4>

                </div>

            </div>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5>
                Welcome to Student Gala
            </h5>

            <p class="text-muted mb-0">
                From this dashboard you can manage your personal
                information and account settings.
            </p>

        </div>

    </div>

</div>


{{-- =====================================================
     PROFILE
====================================================== --}}

<div id="profile"
     class="dashboard-section"
     style="display:none;">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3">
                My Profile
            </h1>

            <p class="text-muted">
                View and manage your personal information.
            </p>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Personal Information
            </h5>

        </div>


        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="text-muted">
                        Full Name
                    </label>

                    <div class="fw-semibold">
                        {{ $user->name }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Email
                    </label>

                    <div class="fw-semibold">
                        {{ $user->email }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Phone
                    </label>

                    <div class="fw-semibold">
                        {{ $user->phone ?? 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        City
                    </label>

                    <div class="fw-semibold">
                        {{ $user->city ?? 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Country
                    </label>

                    <div class="fw-semibold">
                        {{ $user->country ?? 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Role
                    </label>

                    <div>

                        <span class="badge bg-primary">

                            {{ ucfirst(
                                str_replace('_', ' ', $user->role)
                            ) }}

                        </span>

                    </div>

                </div>

            </div>


            <a 
                href="{{ route('user.profile.edit') }}"
                class="btn btn-primary mt-4">
                Edit Profile
            </a>

        </div>

    </div>

</div>

{{-- =====================================================
     AVAILABLE EXAMS
====================================================== --}}

<div id="exams"
     class="dashboard-section"
     style="display:none;">

    <div class="mb-4">

        <h1 class="h3 mb-1">
            Available Exams
        </h1>

        <p class="text-muted">
            Select an exam to view its details and instructions.
        </p>

    </div>


    @if($exams->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-journal-x fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No Exams Available
                </h5>

                <p class="text-muted">
                    There are currently no published exams.
                </p>

            </div>

        </div>

    @else

        <div class="row g-4">

            @foreach($exams as $exam)
                <div class="col-md-6 col-xl-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between
                                        align-items-center mb-3">

                                <span class="badge bg-primary">
                                    {{ $exam->year }}
                                </span>

                                    <span class="badge bg-warning text-dark">
                                        Available
                                    </span>

                            </div>


                            <h5>
                                {{ $exam->subject }}
                            </h5>


                            <p class="text-muted mb-1">

                                <strong>
                                    Department:
                                </strong>

                                {{ $exam->department }}

                            </p>


                            <p class="text-muted mb-1">

                                <strong>
                                    Post:
                                </strong>

                                {{ $exam->post_name }}

                            </p>


                            <p class="text-muted mb-3">

                                <strong>
                                    Questions:
                                </strong>

                                {{ $exam->questions_count }}

                            </p>


                        <hr>
                        <a
                            href="{{ route(
                                'user.exams.show',
                                $exam->id
                            ) }}"
                            class="btn btn-primary w-100">

                            <i class="bi bi-eye me-1"></i>

                            View Exam

                        </a>

                </div>

        </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

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
            View your previous exam attempts and performance.
        </p>

    </div>


    @if($attempts->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-journal-x fs-1 text-muted"></i>

                <h5 class="mt-3">
                    No Attempted Exams
                </h5>

                <p class="text-muted">
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

                            <div class="d-flex justify-content-between
                                        align-items-center mb-3">

                                <h5 class="mb-0">

                                    {{ $attempt->exam->subject ?? 'Exam' }}

                                </h5>

                                <span class="badge bg-success">

                                    Attempted

                                </span>

                            </div>


                            <p class="text-muted mb-1">

                                <strong>
                                    Department:
                                </strong>

                                {{ $attempt->exam->department ?? '-' }}

                            </p>


                            <p class="text-muted mb-1">

                                <strong>
                                    Post:
                                </strong>

                                {{ $attempt->exam->post_name ?? '-' }}

                            </p>


                            <p class="text-muted mb-3">

                                <strong>
                                    Year:
                                </strong>

                                {{ $attempt->exam->year ?? '-' }}

                            </p>


                            <hr>


                            @php

                                $percentage =
                                    $attempt->total_questions > 0
                                    ? (
                                        $attempt->score /
                                        $attempt->total_questions
                                    ) * 100
                                    : 0;

                            @endphp


                            <div class="row text-center mb-3">

                                <div class="col-6">

                                    <small class="text-muted">
                                        Score
                                    </small>

                                    <h4>
                                        {{ $attempt->score }}
                                        /
                                        {{ $attempt->total_questions }}
                                    </h4>

                                </div>


                                <div class="col-6">

                                    <small class="text-muted">
                                        Percentage
                                    </small>

                                    <h4>
                                        {{ number_format(
                                            $percentage,
                                            1
                                        ) }}%
                                    </h4>

                                </div>

                            </div>


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

            @endforeach

        </div>

    @endif

</div>

{{-- =====================================================
     SETTINGS
====================================================== --}}

<div id="settings"
     class="dashboard-section"
     style="display:none;">

    <div class="mb-4">

        <h1 class="h3">
            Settings
        </h1>

        <p class="text-muted">
            Manage your account settings.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5>
                Account Settings
            </h5>


            <div class="form-check form-switch mt-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="emailNotifications"
                    checked>

                <label
                    class="form-check-label"
                    for="emailNotifications">

                    Email Notifications

                </label>

            </div>


            <div class="form-check form-switch mt-3">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="systemNotifications"
                    checked>

                <label
                    class="form-check-label"
                    for="systemNotifications">

                    System Notifications

                </label>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const links =
        document.querySelectorAll('.sidebar-link');

    const sections =
        document.querySelectorAll('.dashboard-section');


    function showSection(sectionId) {

        sections.forEach(function (section) {

            section.style.display = 'none';

        });


        links.forEach(function (link) {

            link.classList.remove('active');

        });


        const selectedSection =
            document.getElementById(sectionId);

        if (selectedSection) {

            selectedSection.style.display = 'block';

        }


        const selectedLink =
            document.querySelector(
                '[data-section="' + sectionId + '"]'
            );

        if (selectedLink) {

            selectedLink.classList.add('active');

        }

    }


    links.forEach(function (link) {

        link.addEventListener('click', function (event) {

            const sectionId =
                this.dataset.section;

            /*
             * Only intercept links that are
             * dashboard sections.
             */

            if (!sectionId) {
                return;
            }

            event.preventDefault();

            showSection(sectionId);

            window.history.replaceState(
                null,
                null,
                this.href
            );

        });

    });


    /*
     * Controller tells us which section
     * should be displayed.
     */

    const controllerSection =
        @json($section ?? 'dashboard');


    /*
     * If URL contains a hash, use it.
     * Otherwise use controller section.
     */

    const hash =
        window.location.hash.replace('#', '');

    const initialSection =
        hash && document.getElementById(hash)
            ? hash
            : controllerSection;


    showSection(
        document.getElementById(initialSection)
            ? initialSection
            : 'dashboard'
    );

});

</script>

@endpush