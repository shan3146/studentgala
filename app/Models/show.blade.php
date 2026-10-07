@extends('layouts.admin')

@section('title', 'User Details')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                User Details
            </h1>

            <p class="text-muted mb-0">
                View account information.
            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.users.index') }}"
                class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back

            </a>


            <a
                href="{{ route('admin.users.edit', $user) }}"
                class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>

                Edit User

            </a>

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
                        {{ $user->phone ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Date of Birth
                    </label>

                    <div class="fw-semibold">
                        {{ $user->date_of_birth ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Gender
                    </label>

                    <div class="fw-semibold">
                        {{ $user->gender ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        City
                    </label>

                    <div class="fw-semibold">
                        {{ $user->city ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Country
                    </label>

                    <div class="fw-semibold">
                        {{ $user->country ?: 'Not provided' }}
                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Role
                    </label>

                    <div>

                        <span class="badge bg-primary">

                            {{ ucfirst($user->role) }}

                        </span>

                    </div>

                </div>


                <div class="col-md-6">

                    <label class="text-muted">
                        Member Since
                    </label>

                    <div class="fw-semibold">

                        {{ $user->created_at->format('d M Y') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection