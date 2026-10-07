@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Edit Profile
            </h1>

            <p class="text-muted mb-0">
                Update your personal information and account details.
            </p>
        </div>

        <a
            href="{{ route('user.dashboard') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back to Dashboard

        </a>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validation Errors --}}
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


    {{-- Profile Card --}}
    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}
        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="bi bi-person-gear me-2"></i>

                Personal Information

            </h5>

        </div>


        {{-- Card Body --}}
        <div class="card-body">

            <form
                action="{{ route('user.profile.update') }}"
                method="POST">

                @csrf
                @method('PUT')


                <div class="row g-4">


                    {{-- Name --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Full Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Enter your full name"
                            required>

                        @error('name')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Email --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Email Address
                            <span class="text-danger">*</span>
                        </label>
                        

                        <input
                            type="email"
                            class="form-control"
                            value="{{ $user->email }}"
                            disabled>

                        <div class="form-text">
                            Email address cannot be changed.
                        </div>

                    </div>


                    {{-- Phone --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Phone Number
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="e.g. 03001234567">

                        @error('phone')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Date of Birth --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Date of Birth
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="date_of_birth"
                            class="form-control"
                            value="{{ old('date_of_birth', $user->date_of_birth) }}">

                        @error('date_of_birth')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Gender --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Gender
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="gender"
                            class="form-select">

                            <option value="">
                                Select Gender
                            </option>

                            <option
                                value="male"
                                @selected(old('gender', $user->gender) === 'male')>
                                Male
                            </option>

                            <option
                                value="female"
                                @selected(old('gender', $user->gender) === 'female')>
                                Female
                            </option>

                            <option
                                value="other"
                                @selected(old('gender', $user->gender) === 'other')>
                                Other
                            </option>

                        </select>

                        @error('gender')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- City --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ old('city', $user->city) }}"
                            placeholder="e.g. Karachi">

                        @error('city')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Address --}}
                    <div class="col-md-12">

                        <label class="form-label">
                            Address
                        </label>

                        <textarea
                            name="address"
                            rows="3"
                            class="form-control"
                            placeholder="Enter your complete address">{{ old('address', $user->address) }}</textarea>

                        @error('address')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Country --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Country
                        </label>

                        <input
                            type="text"
                            name="country"
                            class="form-control"
                            value="{{ old('country', $user->country) }}"
                            placeholder="e.g. Pakistan">

                        @error('country')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                </div>


                <hr class="my-4">


                {{-- Form Buttons --}}
                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('user.dashboard') }}"
                        class="btn btn-secondary">

                        <i class="bi bi-x-circle me-1"></i>

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="bi bi-check-circle me-1"></i>

                        Save Changes

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>

@endsection