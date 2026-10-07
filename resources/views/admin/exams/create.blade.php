@extends('layouts.admin')

@section('title', 'Add Exam')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Add Exam
            </h1>

            <p class="text-muted mb-0">
                Create an exam and upload its MCQs.
            </p>

        </div>

        <a
            href="{{ route('admin.exams.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="bi bi-journal-plus me-2"></i>

                Exam Information

            </h5>

        </div>


        <div class="card-body">


            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('admin.exams.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf


                <div class="row g-4">


                    <!-- Department -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Exam Department

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            name="department"
                            class="form-control"
                            value="{{ old('department') }}"
                            placeholder="e.g. Education Department"
                            required>

                    </div>
					
					<!-- Ad No. -->
					
					<div class="col-md-6">

						<label class="form-label">
							Advertisement No.
						</label>

						<input
							type="text"
							name="advertisement_no"
							class="form-control"
							value="{{ old('advertisement_no') }}"
							placeholder="e.g. Advt. No. 05/2026"
						>

						@error('advertisement_no')
							<div class="text-danger small mt-1">
								{{ $message }}
							</div>
						@enderror

					</div>																																																										


                    <!-- Post -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Post Name

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            name="post_name"
                            class="form-control"
                            value="{{ old('post_name') }}"
                            placeholder="e.g. Computer Operator"
                            required>

                    </div>


                    <!-- BPS -->

                    <div class="col-md-6">

                        <label class="form-label">

                            BPS Scale

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <select
                            name="bps_scale"
                            class="form-select"
                            required>

                            <option value="">
                                Select BPS
                            </option>

                            @for ($i = 1; $i <= 22; $i++)

                                <option
                                    value="BPS-{{ $i }}"
                                    @selected(
                                        old('bps_scale')
                                        === "BPS-$i"
                                    )>

                                    BPS-{{ $i }}

                                </option>

                            @endfor

                        </select>

                    </div>


                    <!-- Year -->

                    <div class="col-md-6">

                        <label class="form-label">

                            Year

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="number"
                            name="year"
                            class="form-control"
                            value="{{ old('year', date('Y')) }}"
                            min="2000"
                            max="2100"
                            required>

                    </div>


                    <!-- Subject -->

                    <div class="col-md-12">

                        <label class="form-label">

                            Subject

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            name="subject"
                            class="form-control"
                            value="{{ old('subject') }}"
                            placeholder="e.g. Linux"
                            required>

                    </div>


                    <!-- Excel -->

                    <div class="col-md-12">

                        <label class="form-label">

                            MCQs Excel File

                            <span class="text-danger">
                                *
                            </span>

                        </label>


                        <input
                            type="file"
                            name="excel_file"
                            class="form-control"
                            accept=".xlsx,.xls"
                            required>


                        <div class="form-text">

                            Upload an Excel file containing:

                            <code>
                                question_id,
                                question_statement,
                                ans_a,
                                ans_b,
                                ans_c,
                                ans_d,
                                correct_ans
                            </code>

                        </div>

                    </div>


                </div>
							<div class="col-md-6">

				<label class="form-label">
					Negative Marking
				</label>

				<select
					name="negative_marking"
					id="negativeMarking"
					class="form-select">

					<option value="0">
						No
					</option>

					<option value="1">
						Yes
					</option>

				</select>

			</div>


			<div class="col-md-6">

				<label class="form-label">
					Negative Marks
				</label>

				<select
					name="negative_marks"
					class="form-select">

					<option value="0">
						0
					</option>

					<option value="0.25">
						0.25
					</option>

					<option value="0.50">
						0.50
					</option>

					<option value="1">
						1
					</option>

				</select>

			</div>


			<div class="col-md-6">

				<label class="form-label">
					Time Per MCQ
				</label>

				<div class="input-group">

					<input
						type="number"
						name="time_per_question"
						class="form-control"
						value="{{ old('seconds_per_question', 75) }}"
						min="1"
						required>

					<span class="input-group-text">
						seconds
					</span>

				</div>

				<div class="form-text">

					Default: 75 seconds per MCQ.

					Total exam time will be calculated
					automatically.

				</div>

			</div>


                <hr class="my-4">


                <div class="d-flex justify-content-end">

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="bi bi-upload me-1"></i>

                        Create Exam & Import MCQs

                    </button>

                </div>


            </form>


        </div>

    </div>

</div>

@endsection