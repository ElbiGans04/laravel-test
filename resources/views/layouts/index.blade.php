<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Welcome Back !')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('js/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">

                    {{ config('app.name') }}

                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @can('users.read')
                <li class="nav-item {{ Route::currentRouteName() == "index" ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('index')}}">
                        <i class="fas fa-users"></i>
                        <span>Users</span></a>
                </li>
            @endcan

            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Data Master
            </div>

            <!-- Nav Item - Dashboard -->
            @can('books.read')
                <li class="nav-item {{ Route::currentRouteName() == "books.index" ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('books.index')}}">
                        <i class="fas fa-book"></i>
                        <span>Book</span></a>
                </li>
            @endcan

            <!-- Nav Item - Dashboard -->
            @can('cars.read')
                <li class="nav-item {{ Route::currentRouteName() == "cars.index" ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('cars.index')}}">
                        <i class="fas fa-car"></i>
                        <span>Cars</span></a>
                </li>
            @endcan


            <!-- Nav Item - Pages Collapse Menu -->
            <!-- Divider -->
            <hr class="sidebar-divider">
            @if(auth()->user()->can('permissions.read') || auth()->user()->can('roles.read'))
                <!-- Heading -->
                <div class="sidebar-heading">
                    SETTING
                </div>
                <li
                    class="nav-item {{ (Route::currentRouteName() == "permissions.index" || Route::currentRouteName() == "roles.index") ? 'active' : '' }}">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                        aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Auth</span>
                    </a>
                    <div id="collapseTwo"
                        class="collapse {{ (Route::currentRouteName() == "permissions.index" || Route::currentRouteName() == "roles.index") ? 'show' : '' }}"
                        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Authorization :</h6>
                            @can('permissions.read')
                                <a class="collapse-item {{ Route::currentRouteName() == "permissions.index" ? "active" : '' }}"
                                    href="{{ route('permissions.index') }}">Permissions</a>
                            @endcan
                            @can('roles.read')
                                <a class="collapse-item {{ Route::currentRouteName() == "roles.index" ? "active" : '' }}"
                                    href="{{ route('roles.index') }}">Roles</a>
                            @endcan
                        </div>
                    </div>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()['email'] }}</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;

                            {{ config('app.name') }}

                            - {{ date('Y') }} </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- All Modal Message -->

</body>

<!-- Bootstrap core JavaScript-->
<!-- <script src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script> -->
<script src="{{ asset('js/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<!-- <script src="{{ asset('js/vendor/jquery-easing/jquery.easing.min.js') }}"></script> -->

<!-- Custom scripts for all pages-->
<script src="{{  asset('js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<!-- <script src="{{ asset('js/vendor/chart.js/Chart.min.js') }}"></script> -->

<!-- Page level custom scripts -->
<!-- <script src="{{  asset('js/demo/chart-area-demo.js')}}"></script>
<script src="{{  asset('js/demo/chart-pie-demo.js')}}"></script> -->

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom -->
@if (Session::has('modal-title'))
    <script>
        Swal.fire({
            title: "{{ Session::get('modal-title') }}",
            text: "{{ Session::get('modal-text') }}",
            icon: "{{ Session::get('modal-icon') }}",
            confirmButtonText: 'OK'
        })
    </script>
@endif

<!-- Additional Scrips -->
@yield('scripts');

</html>