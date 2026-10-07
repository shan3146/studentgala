@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<div class="container-fluid py-4">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="d-flex flex-wrap justify-content-between
                align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Users
            </h1>

            <p class="text-muted mb-0">
                Manage registered users and their account information.
            </p>

        </div>


        <div>

            <a
                href="#"
                class="btn btn-primary">

                <i class="bi bi-person-plus me-1"></i>

                Add User

            </a>

        </div>

    </div>


    {{-- =====================================================
         STAT CARD
    ====================================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex
                                justify-content-between
                                align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Users
                            </p>

                            <h3 class="mb-0">
                                {{ $totalUsers }}
                            </h3>

                        </div>

                        <div
                            class="rounded-circle
                                   bg-primary-subtle
                                   p-3">

                            <i class="bi bi-people
                                      text-primary fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         USERS TABLE CARD
    ====================================================== --}}

    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}

        <div class="card-header bg-white border-0 py-3">

            <div class="row g-3 align-items-center">

                <div class="col-md-7">

                    <h5 class="mb-0">
                        Registered Users
                    </h5>

                </div>


                <div class="col-md-5">

                    <form
                        method="GET"
                        action="{{ route('admin.users.index') }}">

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                class="form-control"
                                placeholder="Search users...">

                            <button
                                type="submit"
                                class="btn btn-outline-primary">

                                <i class="bi bi-search"></i>

                            </button>


                            @if($search)

                                <a
                                    href="{{ route('admin.users.index') }}"
                                    class="btn btn-outline-secondary">

                                    <i class="bi bi-x-lg"></i>

                                </a>

                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- Table --}}

        <div class="card-body p-0">

            @if($users->count())

                <div class="table-responsive">

                    <table
                        class="table table-hover
                               align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4">
                                    #
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Phone
                                </th>

                                <th>
                                    Location
                                </th>

                                <th>
                                    Joined
                                </th>

                                <th class="text-end px-4">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($users as $index => $user)

                                <tr>

                                    {{-- Number --}}

                                    <td class="px-4 text-muted">

                                        {{ $users->firstItem() + $index }}

                                    </td>


                                    {{-- User --}}

                                    <td>

                                        <div
                                            class="d-flex
                                                   align-items-center">

                                            <div
                                                class="rounded-circle
                                                       bg-primary-subtle
                                                       text-primary
                                                       d-flex
                                                       align-items-center
                                                       justify-content-center
                                                       me-3"
                                                style="
                                                    width:42px;
                                                    height:42px;
                                                ">

                                                <strong>

                                                    {{ strtoupper(
                                                        substr(
                                                            $user->name,
                                                            0,
                                                            1
                                                        )
                                                    ) }}

                                                </strong>

                                            </div>


                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $user->name }}

                                                </div>

                                                <small
                                                    class="text-muted">

                                                    User #{{ $user->id }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Email --}}

                                    <td>

                                        <span>

                                            {{ $user->email }}

                                        </span>

                                    </td>


                                    {{-- Phone --}}

                                    <td>

                                        {{ $user->phone
                                            ?: '—' }}

                                    </td>


                                    {{-- Location --}}

                                    <td>

                                        @if($user->city || $user->country)

                                            {{ $user->city }}

                                            @if($user->city && $user->country)
                                                ,
                                            @endif

                                            {{ $user->country }}

                                        @else

                                            <span
                                                class="text-muted">

                                                —

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Joined --}}

                                    <td>

                                        <span
                                            title="{{ $user->created_at }}">

                                            {{ $user->created_at
                                                ->format('d M Y') }}

                                        </span>

                                    </td>


                                    {{-- Actions --}}

                                    <td class="text-end px-4">

                                        <div
                                            class="d-flex
                                                   justify-content-end
                                                   gap-1">

                                            {{-- View --}}

                                            <a
                                                href="{{
                                                    route(
                                                        'admin.users.show',
                                                        $user
                                                    )
                                                }}"
                                                class="btn
                                                       btn-sm
                                                       btn-outline-primary"
                                                title="View User">

                                                <i
                                                    class="bi bi-eye">
                                                </i>

                                                View

                                            </a>


                                            {{-- Edit --}}

                                            <a
                                                href="{{
                                                    route(
                                                        'admin.users.edit',
                                                        $user
                                                    )
                                                }}"
                                                class="btn
                                                       btn-sm
                                                       btn-outline-secondary"
                                                title="Edit User">

                                                <i
                                                    class="bi bi-pencil">
                                                </i>

                                                Edit

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- Empty State --}}

                <div class="text-center py-5">

                    <div
                        class="mb-3">

                        <i
                            class="bi bi-people
                                   text-muted"
                            style="font-size:3rem;">
                        </i>

                    </div>


                    @if($search)

                        <h5>
                            No users found
                        </h5>

                        <p class="text-muted mb-3">

                            No users matched
                            "{{ $search }}".

                        </p>

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="btn btn-outline-primary">

                            Clear Search

                        </a>

                    @else

                        <h5>
                            No users registered
                        </h5>

                        <p class="text-muted mb-0">

                            There are currently no normal users
                            registered in the system.

                        </p>

                    @endif

                </div>

            @endif

        </div>


        {{-- Pagination --}}

        @if($users->hasPages())

            <div class="card-footer bg-white border-0">

                {{ $users->links() }}

            </div>

        @endif

    </div>

</div>

@endsection