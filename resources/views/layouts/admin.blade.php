<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin Dashboard')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">


    <style>

        /* =====================================================
           GENERAL
        ====================================================== */

        body {
            margin: 0;
            background: #f4f6f9;
        }


        /* =====================================================
           ADMIN LAYOUT
        ====================================================== */

        .admin-layout {
            min-height: 100vh;
            display: flex;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .admin-sidebar {

            width: 250px;
            min-width: 250px;
            min-height: 100vh;

            background: #212529;

            position: fixed;

            left: 0;
            top: 0;
            bottom: 0;

            z-index: 1050;

            overflow-y: auto;

            transition:
                width .25s ease,
                min-width .25s ease;

        }


        /* =====================================================
           SIDEBAR BRAND
        ====================================================== */

        .admin-brand {

            height: 60px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 15px 0 20px;

            color: white;

            font-size: 20px;
            font-weight: 600;

            border-bottom:
                1px solid rgba(255,255,255,.1);

        }


        .admin-brand-title {
            white-space: nowrap;
        }


        /* =====================================================
           SIDEBAR TOGGLE
        ====================================================== */

        .sidebar-toggle {

            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 0;
            border-radius: 6px;

            background: rgba(255,255,255,.1);

            color: white;

        }


        .sidebar-toggle:hover {

            background:
                rgba(255,255,255,.2);

            color: white;

        }


        /* =====================================================
           USER AREA
        ====================================================== */

        .admin-user {

            padding: 20px;

            color: white;

            border-bottom:
                1px solid rgba(255,255,255,.1);

        }


        .admin-user small {
            color: #adb5bd;
        }


        /* =====================================================
           SIDEBAR NAVIGATION
        ====================================================== */

        .admin-sidebar .nav-link {

            color: #adb5bd;

            padding: 12px 20px;

            display: flex;

            align-items: center;

            gap: 10px;

            border-radius: 0;

            text-decoration: none;

            white-space: nowrap;

        }


        .admin-sidebar .nav-link:hover {

            color: white;

            background:
                rgba(255,255,255,.08);

        }


        .admin-sidebar .nav-link.active {

            color: white;

            background: #0d6efd;

        }


        .admin-sidebar .nav-link i {

            width: 20px;

            min-width: 20px;

            text-align: center;

        }


        /* =====================================================
           SIDEBAR HEADINGS
        ====================================================== */

        .sidebar-heading {

            color: #6c757d;

            font-size: 11px;

            text-transform: uppercase;

            padding: 18px 20px 8px;

            letter-spacing: .5px;

        }


        /* =====================================================
           MAIN CONTENT
        ====================================================== */

        .admin-main {

            margin-left: 250px;

            min-height: 100vh;

            width: calc(100% - 250px);

            transition:
                margin-left .25s ease,
                width .25s ease;

        }


        /* =====================================================
           TOP BAR
        ====================================================== */

        .admin-topbar {

            height: 60px;

            background: white;

            border-bottom:
                1px solid #dee2e6;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 25px;

        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .admin-content {

            padding: 25px;

        }


        /* =====================================================
           COLLAPSED SIDEBAR - DESKTOP
        ====================================================== */

        .admin-layout.sidebar-collapsed
        .admin-sidebar {

            width: 75px;

            min-width: 75px;

        }


        .admin-layout.sidebar-collapsed
        .admin-main {

            margin-left: 75px;

            width: calc(100% - 75px);

        }


        .admin-layout.sidebar-collapsed
        .admin-brand-title {

            display: none;

        }


        .admin-layout.sidebar-collapsed
        .admin-brand {

            justify-content: center;

            padding: 0;

        }


        .admin-layout.sidebar-collapsed
        .admin-sidebar .nav-link {

            justify-content: center;

            padding-left: 0;
            padding-right: 0;

        }


        .admin-layout.sidebar-collapsed
        .admin-sidebar .nav-link span {

            display: none;

        }


        .admin-layout.sidebar-collapsed
        .admin-sidebar .nav-link i {

            margin: 0 !important;

            font-size: 1.15rem;

        }


        .admin-layout.sidebar-collapsed
        .sidebar-heading {

            display: none;

        }


        .admin-layout.sidebar-collapsed
        .admin-user {

            text-align: center;

            padding: 15px 5px;

        }


        .admin-layout.sidebar-collapsed
        .admin-user > div,
        .admin-layout.sidebar-collapsed
        .admin-user > small {

            display: none;

        }


        /* =====================================================
           EXAM SUBMENU
        ====================================================== */

        .exam-submenu {

            background:
                rgba(0,0,0,.15);

        }


        .exam-submenu .nav-link {

            padding-left: 45px;

            font-size: 14px;

        }


        /* =====================================================
           MOBILE
        ====================================================== */

        .mobile-sidebar-toggle {

            display: none;

        }


        @media (max-width: 768px) {

            .admin-sidebar {

                width: 250px;

                min-width: 250px;

                transform: translateX(-100%);

                transition:
                    transform .25s ease;

            }


            .admin-sidebar.show {

                transform: translateX(0);

            }


            .admin-main {

                margin-left: 0;

                width: 100%;

            }


            /*
             * On mobile the desktop collapse
             * state should not affect the sidebar.
             */

            .admin-layout.sidebar-collapsed
            .admin-sidebar {

                width: 250px;

                min-width: 250px;

            }


            .admin-layout.sidebar-collapsed
            .admin-main {

                margin-left: 0;

                width: 100%;

            }


            .admin-layout.sidebar-collapsed
            .admin-brand-title {

                display: block;

            }


            .admin-layout.sidebar-collapsed
            .admin-brand {

                justify-content: space-between;

                padding: 0 15px 0 20px;

            }


            .admin-layout.sidebar-collapsed
            .admin-sidebar .nav-link {

                justify-content: flex-start;

                padding-left: 20px;

                padding-right: 20px;

            }


            .admin-layout.sidebar-collapsed
            .admin-sidebar .nav-link span {

                display: inline;

            }


            .admin-layout.sidebar-collapsed
            .admin-sidebar .nav-link i {

                margin: 0 !important;

                font-size: 1rem;

            }


            .admin-layout.sidebar-collapsed
            .sidebar-heading {

                display: block;

            }


            .admin-layout.sidebar-collapsed
            .admin-user {

                text-align: left;

                padding: 20px;

            }


            .admin-layout.sidebar-collapsed
            .admin-user > div,
            .admin-layout.sidebar-collapsed
            .admin-user > small {

                display: block;

            }


            .mobile-sidebar-toggle {

                display: inline-flex;

                align-items: center;

                justify-content: center;

            }


            .admin-topbar {

                padding: 0 15px;

            }


            .admin-content {

                padding: 15px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


<div
    id="adminLayout"
    class="admin-layout">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside
        id="adminSidebar"
        class="admin-sidebar">


        {{-- BRAND --}}

        <div class="admin-brand">


            <span class="admin-brand-title">

                Student Gala

            </span>


            {{-- Desktop sidebar toggle --}}

            <button
                type="button"
                id="sidebarToggle"
                class="sidebar-toggle"
                title="Collapse Sidebar">

                <i class="bi bi-list"></i>

            </button>


        </div>


        {{-- USER --}}

        <div class="admin-user">

            <div class="fw-semibold">

                {{ auth()->user()->name }}

            </div>

            <small>

                Administrator

            </small>

        </div>


        {{-- NAVIGATION --}}

        <nav class="mt-2">


            {{-- =================================================
                 DASHBOARD
            ================================================== --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-link
                    {{ request()->routeIs('admin.dashboard')
                        ? 'active'
                        : '' }}">

                <i class="bi bi-speedometer2"></i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- =================================================
                 EXAMINATION
            ================================================== --}}

            <div class="sidebar-heading">

                Examination

            </div>


            <a
                href="#examMenu"
                class="nav-link
                    {{ request()->routeIs('admin.exams.*')
                        ? 'active'
                        : '' }}"
                data-bs-toggle="collapse"
                role="button"
                aria-expanded="{{
                    request()->routeIs('admin.exams.*')
                        ? 'true'
                        : 'false'
                }}">

                <i class="bi bi-journal-text"></i>

                <span class="flex-grow-1">

                    Exams

                </span>

                <i class="bi bi-chevron-down small"></i>

            </a>


            <div
                id="examMenu"
                class="collapse exam-submenu
                    {{ request()->routeIs('admin.exams.*')
                        ? 'show'
                        : '' }}">


                <a
                    href="{{ route('admin.exams.index') }}"
                    class="nav-link">

                    <i class="bi bi-list"></i>

                    <span>
                        All Exams
                    </span>

                </a>


                <a
                    href="{{ route('admin.exams.create') }}"
                    class="nav-link">

                    <i class="bi bi-plus-circle"></i>

                    <span>
                        Add Exam
                    </span>

                </a>


            </div>


            {{-- =================================================
                 USERS
            ================================================== --}}

            <div class="sidebar-heading">
				Users
			</div>

			<a
				href="{{ route('admin.users.index') }}"
				class="nav-link
					{{ request()->routeIs('admin.users.*')
						? 'active'
						: '' }}">

				<i class="bi bi-people"></i>

				<span>
					Users
				</span>

			</a>


            {{-- =================================================
                 RESULTS
            ================================================== --}}

            <div class="sidebar-heading">

                Results

            </div>


            <a
                href="#"
                class="nav-link">

                <i class="bi bi-pencil-square"></i>

                <span>
                    Exam Attempts
                </span>

            </a>


            <a
                href="#"
                class="nav-link">

                <i class="bi bi-bar-chart"></i>

                <span>
                    Reports
                </span>

            </a>


            {{-- =================================================
                 SYSTEM
            ================================================== --}}

            <div class="sidebar-heading">

                System

            </div>


            <a
                href="#"
                class="nav-link">

                <i class="bi bi-gear"></i>

                <span>
                    Settings
                </span>

            </a>


            {{-- =================================================
                 LOGOUT
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-2">

                @csrf


                <button
                    type="submit"
                    class="nav-link border-0 bg-transparent w-100 text-start">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>


        </nav>


    </aside>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <main class="admin-main">


        {{-- =================================================
             TOP BAR
        ================================================== --}}

        <header class="admin-topbar">


            {{-- Mobile sidebar button --}}

            <button
                type="button"
                id="mobileSidebarToggle"
                class="btn btn-light mobile-sidebar-toggle">

                <i class="bi bi-list"></i>

            </button>


            {{-- Desktop title --}}

            <div class="d-none d-md-block">

                <strong>
                    Admin Panel
                </strong>

            </div>


            {{-- USER MENU --}}

            <div class="dropdown">


                <button
                    type="button"
                    class="btn btn-light dropdown-toggle"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ auth()->user()->name }}

                </button>


                <ul
                    class="dropdown-menu dropdown-menu-end">


                    <li>

                        <span
                            class="dropdown-item-text">

                            {{ auth()->user()->email }}

                        </span>

                    </li>


                    <li>

                        <hr
                            class="dropdown-divider">

                    </li>


                    <li>

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf


                            <button
                                type="submit"
                                class="dropdown-item">

                                <i
                                    class="bi bi-box-arrow-right me-2">
                                </i>

                                Logout

                            </button>

                        </form>

                    </li>


                </ul>


            </div>


        </header>


        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        <div class="admin-content">

            @yield('content')

        </div>


    </main>


</div>


{{-- =========================================================
     BOOTSTRAP
========================================================= --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


{{-- =========================================================
     SIDEBAR JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const layout =
            document.getElementById(
                'adminLayout'
            );


        const sidebar =
            document.getElementById(
                'adminSidebar'
            );


        const desktopToggle =
            document.getElementById(
                'sidebarToggle'
            );


        const mobileToggle =
            document.getElementById(
                'mobileSidebarToggle'
            );


        if (
            !layout ||
            !sidebar
        ) {

            return;

        }


        /* =====================================================
           DESKTOP SIDEBAR STATE
        ====================================================== */


        const savedState =
            localStorage.getItem(
                'adminSidebarCollapsed'
            );


        if (
            savedState === 'true' &&
            window.innerWidth > 768
        ) {

            layout.classList.add(
                'sidebar-collapsed'
            );

        }


        /* =====================================================
           DESKTOP TOGGLE
        ====================================================== */


        if (desktopToggle) {

            desktopToggle.addEventListener(
                'click',
                function () {


                    if (
                        window.innerWidth <= 768
                    ) {

                        return;

                    }


                    layout.classList.toggle(
                        'sidebar-collapsed'
                    );


                    const collapsed =
                        layout.classList.contains(
                            'sidebar-collapsed'
                        );


                    localStorage.setItem(
                        'adminSidebarCollapsed',
                        collapsed
                    );


                }
            );

        }


        /* =====================================================
           MOBILE TOGGLE
        ====================================================== */


        if (mobileToggle) {

            mobileToggle.addEventListener(
                'click',
                function () {

                    sidebar.classList.toggle(
                        'show'
                    );

                }
            );

        }


        /* =====================================================
           CLOSE MOBILE SIDEBAR
           WHEN LINK IS CLICKED
        ====================================================== */


        sidebar
            .querySelectorAll('a')
            .forEach(function (link) {


                link.addEventListener(
                    'click',
                    function () {


                        if (
                            window.innerWidth <= 768
                        ) {

                            sidebar.classList.remove(
                                'show'
                            );

                        }

                    }
                );


            });


        /* =====================================================
           HANDLE WINDOW RESIZE
        ====================================================== */


        window.addEventListener(
            'resize',
            function () {


                if (
                    window.innerWidth > 768
                ) {

                    sidebar.classList.remove(
                        'show'
                    );

                }


            }
        );


    }
);

</script>


@stack('scripts')


</body>

</html>