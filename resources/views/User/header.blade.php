<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enabled"
      data-bs-theme="light">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
        <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
        <!-- Layout config Js -->
        <script src="{{ asset('public/dashboard/assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('public/dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('public/dashboard/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('public/dashboard/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('public/dashboard/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Datatable CSS -->
        <link href="{{ asset('public/dashboard/assets/css/dataTables.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- JQuery CDN -->
        <script src="{{ asset('public/dashboard/assets/js/jquery-3.7.1.min.js') }}"></script>
        <!-- Datatable JS -->
        <script src="{{ asset('public/dashboard/assets/js/dataTables.min.js') }}"></script>
        <!-- Sweet Alert 2 CDN -->
        <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        <style>
            .logout-btn {
                cursor: pointer !important;
            }
        </style>
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
                                <a href="{{ url('/user-dashboard') }}" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ asset('public/dashboard/assets/images/logo-sm.png') }}" alt="" height="22" />
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('public/dashboard/assets/images/logo-dark.png') }}" alt="" height="17" />
                                    </span>
                                </a>

                                <a href="{{ url('/user-dashboard') }}" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ asset('public/dashboard/assets/images/logo-sm.png') }}" alt="" height="22" />
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('public/dashboard/assets/images/logo-light.png') }}" alt="" height="17" />
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                                <span class="hamburger-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </button>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="ms-1 header-item d-none d-sm-flex">
                                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                    <i class="bx bx-fullscreen fs-22"></i>
                                </button>
                            </div>

                            <div class="dropdown ms-sm-3 header-item topbar-user">
                                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <span class="d-flex align-items-center">
                                        <img class="rounded-circle header-profile-user" src="{{ asset('public/assets/img/uploads/documents/user.png') }}"
                                             alt="Header Avatar" />
                                        <span class="text-start ms-xl-2">
                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Session::get('fusername') }}
                                                {{ Session::get('lusername') }}</span>
                                            <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">User</span>
                                        </span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <h6 class="dropdown-header">Welcome {{ Session::get('fusername') }}!</h6>
                                    <a class="dropdown-item" href="{{ url('/user/profile') }}"><i
                                           class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle">Profile</span></a>
                                    {{-- <a class="dropdown-item" href="{{ url('/user/help') }}"><i
                                           class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle">Help</span></a> --}}
                                    <a class="dropdown-item" href="{{ url('/logout') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                        <span class="align-middle" data-key="t-logout">Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- removeNotificationModal -->
            <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548"
                                           style="width: 100px; height: 100px"></lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        Are you sure you want to remove this
                                        Notification ?
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn w-sm btn-danger" id="delete-notification">
                                    Yes, Delete It!
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{ url('/user-dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('public/dashboard/assets/images/logo-sm.png') }}" alt="" height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('public/dashboard/assets/images/logo-dark.png') }}" alt="" height="17" />
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{ url('/user-dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('public/dashboard/assets/images/logo-sm.png') }}" alt="" height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('public/dashboard/assets/images/logo-light.png') }}" alt="" height="17" />
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">
                        <div id="two-column-menu"></div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title">
                                <i class="ri-more-fill"></i>
                                <span data-key="t-pages">Menu</span>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link dashboard" href="{{ url('/user-dashboard') }}">
                                    <i class="ri-dashboard-2-line"></i>
                                    <span data-key="t-widgets">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link profile" href="{{ url('/user/profile') }}">
                                    <i class="ri-account-circle-fill"></i>
                                    <span data-key="t-widgets">Profiles</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link documents" href="{{ url('/user/documents') }}">
                                    <i class="ri-file-fill"></i>
                                    <span data-key="t-widgets">Doucments</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link invoices" href="{{ url('/user/invoices') }}">
                                    <i class="ri-price-tag-2-fill"></i>
                                    <span data-key="t-widgets">Invoices</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link approval-letter" href="{{ url('/user/approval-letter') }}">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    <span data-key="t-widgets">Approval Letter</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link bank-details" href="{{ url('/user/bank-details') }}">
                                    <i class="ri-bank-fill"></i>
                                    <span data-key="t-widgets">Bank Details</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link payments" href="{{ url('/user/payments') }}">
                                    <i class="ri-refund-2-fill"></i>
                                    <span data-key="t-widgets">Payments</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link download" href="{{ url('/user/download') }}">
                                    <i class="ri-download-cloud-fill"></i>
                                    <span data-key="t-widgets">Download</span>
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
                <div class="page-content" style="min-height: 92vh!important;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="h-100">
