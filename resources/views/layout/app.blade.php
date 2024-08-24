<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">


<!-- Mirrored from themesbrand.com/velzon/html/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Sep 2022 15:00:54 GMT -->

<head>

    <meta charset="utf-8" />
    <title>PSX_I | Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    {{-- <img src="assets/images/logo-sm.png" alt="" height="22"> --}}
                                </span>
                                <span class="logo-lg">
                                    {{-- <img src="assets/images/logo-dark.png" alt="" height="17"> --}}
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    {{-- <img src="assets/images/logo-sm.png" alt="" height="22"> --}}
                                </span>
                                <span class="logo-lg">
                                    {{-- <img src="assets/images/logo-light.png" alt="" height="17"> --}}
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-md-block">

                            <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                                <div data-simplebar style="max-height: 320px;">
                                    <!-- item-->
                                    <div class="dropdown-header">
                                        <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                                    </div>

                                    <div class="dropdown-item bg-transparent text-wrap">
                                        <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">how to
                                            setup <i class="mdi mdi-magnify ms-1"></i></a>
                                        <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">buttons
                                            <i class="mdi mdi-magnify ms-1"></i></a>
                                    </div>
                                    <!-- item-->
                                    <div class="dropdown-header mt-2">
                                        <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                        <span>Analytics Dashboard</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                        <span>Help Center</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                        <span>My account settings</span>
                                    </a>

                                    <!-- item-->
                                    <div class="dropdown-header mt-2">
                                        <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                                    </div>
                                     {{-- notification avatar code --}}
                                    {{-- <div class="notification-list">
                                        <!-- item -->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-2.jpg"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">Angela Bernier</h6>
                                                    <span class="fs-11 mb-0 text-muted">Manager</span>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- item -->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-3.jpg"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">David Grasso</h6>
                                                    <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- item -->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                            <div class="d-flex">
                                                <img src="assets/images/users/avatar-5.jpg"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">Mike Bunch</h6>
                                                    <span class="fs-11 mb-0 text-muted">React Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div> --}}
                                </div>

                                <div class="text-center pt-3 pb-1">
                                    <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All
                                        Results <i class="ri-arrow-right-line ms-1"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        {{-- notification --}}
                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle position-relative"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                <span class="badge bg-primary rounded-circle position-absolute top-0 start-50 "
                                    style="left: 60%;">
                                    <?php
                                    $withdrawCount = $withdrawrequests->where('status', 0)->count(); // Get the count of withdrawal requests
                                    $depositCount = $depositRequests->where('status', 0)->count(); // Get the count of deposit requests
                                    $totalRequests = $withdrawCount + $depositCount; // Calculate the total number of requests
                                    ?>
                                    <small><?php echo $totalRequests; ?></small>

                                </span>
                            </button>


                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">

                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="px-2 pt-2">
                                        <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom"
                                            data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                                    role="tab" aria-selected="true">
                                                    All MESSAGES
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="tab-content" id="notificationItemsTabContent">
                                    <div class="mt-2">
                                        <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab"
                                            role="tabpanel">
                                            @if (isset($withdrawrequests))
                                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                                    <!-- Display last 20 withdrawal requests -->
                                                    @foreach ($withdrawrequests->take(20) as $key => $withdrawrequest)
                                                        <div class="notification-wrapper">
                                                            <div
                                                                class="text-reset notification-item d-block dropdown-item position-relative active">
                                                                <div class="d-flex">
                                                                    <div class="mt-2">
                                                                        <div class="mt-2">
                                                                            <div class="flex-1">
                                                                                <a href="#!"
                                                                                    class="stretched-link">
                                                                                    <h6
                                                                                        class="mt-2 mb-1 fs-13 fw-semibold">
                                                                                        {{ $withdrawrequest->accountholder }}
                                                                                    </h6>
                                                                                </a>
                                                                                <div class="fs-13 text-muted">
                                                                                    <p class="mb-1">
                                                                                        {{ $withdrawrequest->accountholder }}
                                                                                        wants to withdraw this amount (
                                                                                        {{ $withdrawrequest->withdrawamount }})
                                                                                        in this bank (
                                                                                        {{ $withdrawrequest->bank->bank }}
                                                                                        ) 🔔.
                                                                                    </p>
                                                                                </div>
                                                                                <p
                                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                                    <span><i
                                                                                            class="mdi mdi-clock-outline"></i>
                                                                                        {{ $withdrawrequest->created_at }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="px-2 fs-15">
                                                                        <div class="form-check notification-check">
                                                                            <label class="form-check-label"
                                                                                for="all-notification-check02"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    @foreach ($depositRequests->take(20) as $key => $depositrequest)
                                                        <div class="notification-wrapper">
                                                            <div
                                                                class="text-reset notification-item d-block dropdown-item position-relative active">
                                                                <div class="d-flex">
                                                                    <div class="mt-2">
                                                                        <div class="mt-2">
                                                                            <div class="flex-1">
                                                                                <a href="#!"
                                                                                    class="stretched-link">
                                                                                    <h6
                                                                                        class="mt-2 mb-1 fs-13 fw-semibold">
                                                                                        {{ $depositrequest->accountholder }}
                                                                                    </h6>
                                                                                </a>
                                                                                <div class="fs-13 text-muted">
                                                                                    <p class="mb-1">
                                                                                        {{ $depositrequest->accountholder }}
                                                                                        wants to withdraw this amount (
                                                                                        {{ $depositrequest->depositamount }})
                                                                                        in this bank (
                                                                                        {{ $depositrequest->bank->bank }}
                                                                                        ) 🔔.
                                                                                    </p>
                                                                                </div>
                                                                                <p
                                                                                    class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                                                    <span><i
                                                                                            class="mdi mdi-clock-outline"></i>
                                                                                        {{ $depositrequest->created_at }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="px-2 fs-15">
                                                                        <div class="form-check notification-check">
                                                                            <label class="form-check-label"
                                                                                for="all-notification-check02"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach



                                                    <!-- Add a number icon on top to represent the count of new requests -->
                                                    {{-- <div class="my-3 text-center">
                                                    <span class="badge badge-primary"></span>
                                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                        View All Notifications <i class="ri-arrow-right-line align-middle"></i>
                                                    </button>
                                                </div> --}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- notification --}}
                        {{--
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div> --}}



                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                            {{ auth()->user()->adminname }}
                                        </span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome {{ auth()->user()->adminname }}!</h6>
                                <a class="dropdown-item" href="/admin/profile_update/view">
                                    <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle">Profile</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <h2 class="text-light mt-2">
                             <?php  
                            $setting = App\Models\Setting::where('key', 'name')->get()->first();
                            if ($setting) {
                                echo $setting->value;
                            } else {
                                echo 'Brand name not found';
                            }
                            ?>
                        </h2>
                    </span>
                    <span class="logo-lg">
                        <h2 class="text-light mt-2">
                             <?php  
                            $setting = App\Models\Setting::where('key', 'name')->get()->first();
                            if ($setting) {
                                echo $setting->value;
                            } else {
                                echo 'Brand name not found';
                            }
                            ?>
                        </h2>
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <h2 class="text-light mt-2">
                             <?php  
                            $setting = App\Models\Setting::where('key', 'name')->get()->first();
                            if ($setting) {
                                echo $setting->value;
                            } else {
                                echo 'Brand name not found';
                            }
                            ?>
                        </h2>
                    </span>
                    <span class="logo-lg">
                        <h2 class="text-light mt-2">
                             <?php  
                            $setting = App\Models\Setting::where('key', 'name')->get()->first();
                            if ($setting) {
                                echo $setting->value;
                            } else {
                                echo 'Brand name not found';
                            }
                            ?>
                        </h2>
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/dashboard">
                                <i class="ri-dashboard-2-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/user/index">
                                <i class="ri-user-line"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/scheme/index">
                                <i class="ri-dashboard-2-line"></i> Schemes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/investment/index">
                                <i class="ri-exchange-line"></i> Trades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/bank/index">
                                <i class="ri-bank-line"></i> Banks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/adminbank/index">
                                <i class="ri-dashboard-2-line"></i> Admin Banks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/userbank/index">
                                <i class="ri-bank-line"></i> User Bank Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/sendnotification/index">
                                <i class="ri-notification-line"></i> Send Notification
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/deposit/index">
                                <i class="ri-dashboard-2-line"></i>Deposit History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/withdraw/index">
                                <i class="ri-dashboard-2-line"></i>Withdraw History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="/admin/settings">
                                <i class="ri-settings-3-line"></i>Settings
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- end page title -->

                    @if ($message = Session::get('success'))
                        <div id="successMessage" class="alert alert-primary text-primary mt-3">
                            <p class="fs-14">{{ $message }}</p>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div id="dangerMessage" class="alert alert-danger text-primary mt-3">
                            <p class="fs-14">{{ $message }}</p>
                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Something went wrong.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">

                            @yield('content')

                        </div> <!-- end col -->

                      
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Maventics.
                            </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Maventics
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->



    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js" async></script>
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    
@yield('scritps')
</body>


<!-- Mirrored from themesbrand.com/velzon/html/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Sep 2022 15:02:13 GMT -->

</html>