@extends('layouts.admin')

@section('title', 'Exam Management')

@section('content')

<div class="container-fluid">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Exam Management
            </h1>

            <p class="text-muted mb-0">
                Manage examinations, questions and candidate attempts.
            </p>

        </div>

        <a
            href="{{ route('admin.exams.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>

            Add Exam

        </a>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.exams.index') }}">

                <div class="row g-3 align-items-end">


                    {{-- Department --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Department
                        </label>

                        <select
                            name="department"
                            class="form-select">

                            <option value="">
                                All Departments
                            </option>

                            @foreach($departments as $department)

                                <option
                                    value="{{ $department }}"
                                    @selected(
                                        request('department') == $department
                                    )>

                                    {{ $department }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Year --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            Year
                        </label>

                        <select
                            name="year"
                            class="form-select">

                            <option value="">
                                All Years
                            </option>

                            @foreach($years as $year)

                                <option
                                    value="{{ $year }}"
                                    @selected(
                                        request('year') == $year
                                    )>

                                    {{ $year }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Subject --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Subject
                        </label>

                        <select
                            name="subject"
                            class="form-select">

                            <option value="">
                                All Subjects
                            </option>

                            @foreach($subjects as $subject)

                                <option
                                    value="{{ $subject }}"
                                    @selected(
                                        request('subject') == $subject
                                    )>

                                    {{ $subject }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Sort --}}

                    <div class="col-md-2">

                        <label class="form-label">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="form-select">

                            <option
                                value="created_at"
                                @selected(
                                    request('sort') === 'created_at'
                                )>

                                Sequence

                            </option>

                            <option
                                value="department"
                                @selected(
                                    request('sort') === 'department'
                                )>

                                Department

                            </option>

                            <option
                                value="year"
                                @selected(
                                    request('sort') === 'year'
                                )>

                                Year

                            </option>

                            <option
                                value="subject"
                                @selected(
                                    request('sort') === 'subject'
                                )>

                                Subject

                            </option>

                            <option
                                value="post_name"
                                @selected(
                                    request('sort') === 'post_name'
                                )>

                                Post

                            </option>

                            <option
                                value="status"
                                @selected(
                                    request('sort') === 'status'
                                )>

                                Status

                            </option>

                        </select>

                    </div>


                    {{-- Direction --}}

                    <div class="col-md-1">

                        <label class="form-label">
                            Order
                        </label>

                        <select
                            name="direction"
                            class="form-select">

                            <option value="asc"
                                @selected(
                                    request('direction') === 'asc'
                                )>

                                A-Z

                            </option>

                            <option value="desc"
                                @selected(
                                    request('direction') === 'desc'
                                )>

                                Z-A

                            </option>

                        </select>

                    </div>


                    {{-- Apply --}}

                    <div class="col-md-1">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-funnel"></i>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         EXAMS TABLE
    ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Advertisement
                            </th>

                            <th>
                                Department
                            </th>

                            <th>
                                Post
                            </th>

                            <th>
                                BPS
                            </th>

                            <th>
                                Year
                            </th>

                            <th>
                                Subject
                            </th>

                            <th>
                                Questions
                            </th>

                            <th>
                                Attempts
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($exams as $index => $exam)

                            <tr>

                                {{-- Sequence --}}

                                <td class="fw-semibold">

                                    {{ $index + 1 }}

                                </td>


                                {{-- Advertisement --}}

                                <td>

                                    {{ $exam->advertisement_no ?? '—' }}

                                </td>


                                {{-- Department --}}

                                <td>

                                    {{ $exam->department }}

                                </td>


                                {{-- Post --}}

                                <td>

                                    {{ $exam->post_name }}

                                </td>


                                {{-- BPS --}}

                                <td>

                                    {{ $exam->bps_scale }}

                                </td>


                                {{-- Year --}}

                                <td>

                                    {{ $exam->year }}

                                </td>


                                {{-- Subject --}}

                                <td>

                                    {{ $exam->subject }}

                                </td>


                                {{-- Questions --}}

                                <td>

                                    <span class="badge bg-light text-dark">

                                        {{ $exam->questions_count }}

                                    </span>

                                </td>


                                {{-- Attempts --}}

                                <td>

                                    <span class="badge bg-primary">

                                        {{ $exam->attempts_count }}

                                    </span>

                                </td>


                                {{-- Status --}}

                                <td>

                                    @if($exam->status === 'published')

                                        <span class="badge bg-success">

                                            Published

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            Draft

                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}

                                <td class="text-end">

									<div class="d-flex justify-content-end gap-1">

										{{-- Preview --}}

										<a
											href="{{ route('admin.exams.show', $exam) }}"
											class="btn btn-sm btn-outline-primary"
											title="Preview Exam">

											<i class="bi bi-eye"></i>

											Preview

										</a>


										{{-- Publish / Unpublish --}}

										<form
											method="POST"
											action="{{ route(
												'admin.exams.toggle-status',
												$exam
											) }}"
											class="d-inline">

											@csrf

											@method('PATCH')

											@if($exam->status === 'published')

												<button
													type="submit"
													class="btn btn-sm btn-outline-warning"
													title="Move exam back to draft"
													onclick="return confirm(
														'Are you sure you want to move this exam back to draft?'
													);">

													<i class="bi bi-eye-slash me-1"></i>

													Unpublish

												</button>

											@else

												<button
													type="submit"
													class="btn btn-sm btn-outline-success"
													title="Publish exam"
													onclick="return confirm(
														'Are you sure you want to publish this exam?'
													);">

													<i class="bi bi-check-circle me-1"></i>

													Publish

												</button>

											@endif

										</form>

									</div>

								</td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="11"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i
                                            class="bi bi-inbox fs-2 d-block mb-2">
                                        </i>

                                        No exams found.

                                    </div>

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