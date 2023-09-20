<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Xuexi - @yield('title') </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    {{-- <link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet"> --}}
	<link rel="stylesheet" href="{{ asset('vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">

	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    @stack('styles')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('images/logo.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->


		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                @yield('title')
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link dz-fullscreen" href="#">
                                    <svg id="icon-full" viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
                                    <svg id="icon-minimize" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"></path></svg>
                                </a>
							</li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
									<div class="header-info">
										<span>{{ session('user')['first_name'] . " " . session('user')['last_name']}} </span>
										<small>
                                            Administrator

                                        </small>
									</div>
                                    <img src="{{ asset('images/vecteezy_default-profile-picture-avatar-user-avatar-icon-person_21548095.jpg') }}" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    {{-- <a href="./app-profile.html" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a> --}}
                                    <a href="javascript:void(0);" onclick="logout()" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li><a href="{{ route('admins.index') }}" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-briefcase"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                    <li><a href="{{ route('students.index') }}" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Students</span>
                        </a>
                    </li>

                    <li><a href="{{ route('assessment.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-notepad"></i>
                            <span class="nav-text">Assessments</span>
                        </a>
                    </li>
                    <li><a href="{{ route('quiz.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-list"></i>
                            <span class="nav-text">Quizzes</span>
                        </a>
                    </li>
                </ul>


				<div class="copyright">
					<p><strong>Xuexi</strong> © 2023 All Rights Reserved</p>
					<p>Made with <i class="fa fa-heart"></i></p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				{{-- MAIN CONTENT --}}
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
        @csrf
        {{-- <input type="hidden" name="logout" value="1"> --}}
    </form>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script>
        function logout() {
            document.getElementById('logoutForm').submit();
        }
    </script>
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
	<script src="{{ asset('js/deznav-init.js') }}"></script>
	<!-- Apex Chart -->
	{{-- <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script> --}}


	<!-- Dashboard 1 -->
	{{-- <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script> --}}
    @stack('scripts')

</body>
</html>
