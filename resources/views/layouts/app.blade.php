<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Student Gala')
    </title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background-color: #f4f6f9;
        }

        .main-wrapper {
            min-height: 100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | Sidebar
        |--------------------------------------------------------------------------
        */

        .sidebar {
            position: fixed;

            top: 0;
            bottom: 0;
            left: 0;

            width: 250px;

            background-color: #343a40;

            z-index: 1040;

            transition: 0.3s;
        }

        .sidebar-brand {
            height: 60px;

            display: flex;
            align-items: center;

            padding: 0 20px;

            color: white;

            font-size: 20px;
            font-weight: 600;

            text-decoration: none;

            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sidebar-menu {
            padding: 15px 10px;
        }

        .sidebar-menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 12px 15px;

            margin-bottom: 4px;

            color: #c2c7d0;

            text-decoration: none;

            border-radius: 5px;

            transition: 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: #495057;

            color: white;
        }

        .sidebar-menu a.active {
            background-color: #007bff;

            color: white;
        }


        /*
        |--------------------------------------------------------------------------
        | Main Area
        |--------------------------------------------------------------------------
        */

        .main-content {
            margin-left: 250px;

            min-height: 100vh;

            transition: 0.3s;
        }


        /*
        |--------------------------------------------------------------------------
        | Navbar
        |--------------------------------------------------------------------------
        */

        .top-navbar {
            height: 60px;

            background-color: white;

            border-bottom: 1px solid #dee2e6;

            display: flex;

            align-items: center;

            padding: 0 20px;
        }

        .menu-toggle {
            border: none;

            background: transparent;

            font-size: 22px;

            cursor: pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | Page Content
        |--------------------------------------------------------------------------
        */

        .page-content {
            padding: 25px;
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .sidebar {
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


<div class="main-wrapper">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <aside
        id="sidebar"
        class="sidebar">


        <!-- Brand -->

        <a
            href="{{ route('user.dashboard') }}"
            class="sidebar-brand">

            <i class="bi bi-mortarboard-fill"></i>

            Student Gala

        </a>


        <!-- Menu -->

        <div class="sidebar-menu">


		<a href="{{ route('user.dashboard') }}"
		class="sidebar-link"
		data-section="dashboard">

		<i class="bi bi-speedometer2"></i>
		<span>Dashboard</span>

		</a>


		<a href="{{ route('user.dashboard') }}#profile"
		class="sidebar-link"
		data-section="profile">

		<i class="bi bi-person"></i>
		<span>My Profile</span>

		</a>


		<a href="{{ route('user.dashboard') }}#exams"
		class="sidebar-link"
		data-section="exams">

		<i class="bi bi-journal-text"></i>
		<span>Available Exams</span>

		</a>


		<a href="{{ route('user.attempted') }}"
		class="sidebar-link"
		data-section="attempted">

		<i class="bi bi-clock-history"></i>
		<span>Attempted Exams</span>

		</a>


        <a href="{{ route('user.settings') }}"
		class="sidebar-link"
		data-section="settings">

		<i class="bi bi-gear"></i>
		<span>Settings</span>

		</a>

            <!-- Logout -->

            <a
                href="#"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>


            <form
                id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none">

                @csrf

            </form>


        </div>

    </aside>



    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <div class="main-content">


        <!-- =================================================
             NAVBAR
        ================================================== -->

        <nav class="top-navbar">


            <button
                id="menuToggle"
                class="menu-toggle">

                <i class="bi bi-list"></i>

            </button>


            <div class="ms-auto d-flex align-items-center">


                @auth

                    <span class="me-3">

                        {{ auth()->user()->name }}

                    </span>


                    <div
                        class="rounded-circle
                               bg-primary
                               text-white
                               d-flex
                               align-items-center
                               justify-content-center"
                        style="width:40px;height:40px;">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                @endauth


            </div>


        </nav>



        <!-- =================================================
             PAGE CONTENT
        ================================================== -->

        <main class="page-content">

            @yield('content')

        </main>


    </div>


</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

document
    .getElementById('menuToggle')
    .addEventListener('click', function () {

        document
            .getElementById('sidebar')
            .classList
            .toggle('show');

    });

</script>


@stack('scripts')

</body>

</html>