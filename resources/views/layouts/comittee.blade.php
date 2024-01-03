<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/inspace-logo.png') }}">
    <title>{{ $title }}</title>

    <!-- Custom CSS -->
    <link href="{{ asset('src/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('src/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('src/dist/css/style.css') }}" rel="stylesheet">
    @yield('css')
    @stack('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="#">
                            <center>
                                <b class="logo-icon">
                                    <!-- Dark Logo icon -->
                                    <img src="{{ asset('images/inspace-logo.png') }}" alt="homepage" class="dark-logo" width="30%" />
                                    <!-- Light Logo icon -->
                                    <img src="{{ asset('images/inspace-logo.png') }}" alt="homepage" class="light-logo" width="30%" />
                                </b>
                            </center>
                            <!--End Logo icon -->
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ auth()->guard('comittee')->user()->avatar == null ? asset('src/assets/images/users/profile-pic.jpg') : asset(auth()->guard('comittee')->user()->avatar)  }}" alt="user" class="rounded-circle" width="40">
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span class="text-dark">{{ \Illuminate\Support\Str::words(auth()->guard('comittee')->user()->name, 2, '') }}</span> <i data-feather="chevron-down" class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('comittees.settings') }}"><i data-feather="settings" class="svg-icon mr-2 ml-1"></i>
                                    Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('comittee.logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                                    Logout</a>

                                <form id="logout-form" action="{{ route('comittee.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span></a></li>
                        <li class="list-divider"></li>

                        <li class="nav-small-cap"><span class="hide-menu">Comittee Area</span></li>
                        @if (accessMenu('participants') || accessMenu('comittees'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span class="hide-menu">Users</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                @if (accessMenu('participants'))
                                <li class="sidebar-item">
                                    <a href="{{ route('participants.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> Participants</span>
                                    </a>
                                </li>
                                @endif
                                @if (accessMenu('comittees'))
                                <li class="sidebar-item">
                                    <a href="{{ route('comittees.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> Comittees</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('programs'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="settings" class="feather-icon"></i><span class="hide-menu">Programs</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('programs.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> List Program</span>
                                    </a>
                                </li>
                                @if(auth()->guard('comittee')->user()->section == 'Web Development' or auth()->guard('comittee')->user()->section == 'Acara')
                                    <li class="sidebar-item">
                                        <a href="{{ route('programs.create') }}" class="sidebar-link">
                                            <span class="hide-menu"> Add Program</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('active'))
                        <li class="sidebar-item">
                            <a class="has-arrow sidebar-link" href="javascript:void(0)" aria-expanded="false"><i data-feather="check" class="feather-icon"></i><span class="hide-menu">Active Programs</span></a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                @foreach($activePrograms as $program)
                                    <li class="sidebar-item">
                                        <a href="javascript:void(0)" class="sidebar-link has-arrow">
                                            <span class="hide-menu"> {{ $program->name }}</span>
                                        </a>
                                        <ul aria-expanded="false" class="collapse second-level base-level-line in">
                                            <li class="sidebar-item">
                                                <a href="{{ route('active.program', $program->slug) }}" class="sidebar-link">
                                                    <span class="hide-menu"> All Participants</span>
                                                </a>
                                            </li>
                                            @foreach ($program->stages_data->get('stage_list') as $key => $stage)
                                            <li class="sidebar-item">
                                                <a href="{{ route('active.program.selection', [
                                                    'program' => $program->slug,
                                                    'no_stage' => strval($key+1)
                                                    ]) }}" class="sidebar-link">
                                                    <span class="hide-menu"> {{ $stage->label }}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                            <li class="sidebar-item">
                                                <a href="{{ route('active.program.winner',$program->slug) }}" class="sidebar-link">
                                                    <span class="hide-menu"> Winner</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('agenda') || accessMenu('addon-variant'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="list" class="feather-icon"></i><span class="hide-menu">Agenda</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                @if (accessMenu('agenda'))
                                <li class="sidebar-item">
                                    <a href="{{ route('agenda.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> List Agenda</span>
                                    </a>
                                </li>
                                @endif
                                @if (accessMenu('addon-variant'))
                                <li class="sidebar-item">
                                    <a href="{{ route('addonVariant.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> Addon Variant</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('announcements'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="bell" class="feather-icon"></i><span class="hide-menu">Announcement</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('announcements.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> List Announcement</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('announcements.create') }}" class="sidebar-link">
                                        <span class="hide-menu"> Add Announcement</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('medpart'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-handshake"></i><span class="hide-menu">Media Partner</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('medpart.index') }}" class="sidebar-link">
                                        <span class="hide-menu"> List Media Partner</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('medpart.create') }}" class="sidebar-link">
                                        <span class="hide-menu"> Add Media Partner</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('faq'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="bell" class="feather-icon"></i><span class="hide-menu">Faq</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('faq.index') }}" class="sidebar-link">
                                        <span class="hide-menu">List Of FAQ</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('faq.create') }}" class="sidebar-link">
                                        <span class="hide-menu">ADD FAQ</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (accessMenu('deskripsi'))
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="bell" class="feather-icon"></i><span class="hide-menu">Deskripsi</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('deskripsi.index') }}" class="sidebar-link">
                                        <span class="hide-menu">Deskripsi</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (auth()->guard('comittee')->user()->isWebDev())
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link {{ Request::is('/division') ? 'active' : '' }}" href="{{ url('/division') }}" aria-expanded="false"><i data-feather="key" class="feather-icon"></i><span class="hide-menu">Division Management</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link {{ Request::is('/activity-log') ? 'active' : '' }}" href="{{ url('/activity-log') }}" aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Activity Log</span></a></li>
                        @endif
                        <br>

                        @if(auth()->guard('comittee')->user()->section == 'Web Development')
                        <li class="nav-small-cap"><span class="hide-menu">Developer Area</span></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i data-feather="play" class="feather-icon"></i><span class="hide-menu">Playground</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('registration') }}" class="sidebar-link">
                                        <span class="hide-menu"> Registration</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">
                                        <span class="hide-menu"> Send Email</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">
                                        <span class="hide-menu"> Payment Gateaway</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @yield('content')
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by INSPACE. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- apps -->
    <script src="{{ asset('src/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('src/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('src/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('src/dist/js/custom.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/49325be119.js" crossorigin="anonymous"></script>
    <!--This page JavaScript -->
    <script src="{{ asset('src/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('src/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('src/dist/js/pages/dashboards/dashboard1.min.js') }}"></script>

    @yield('js')
    @stack('js')
</body>

</html>
