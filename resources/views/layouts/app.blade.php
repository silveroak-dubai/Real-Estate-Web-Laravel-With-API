<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('settings.site_title') ? config('settings.site_title') : config('app.site_title') }}</title>
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">
    <!--plugins-->
    <link href="{{ asset('css') }}/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/mm-vertical.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/simplebar.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css') }}/font-awesome.min.css">
    <!--bootstrap css-->
    <link href="{{ asset('css') }}/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- datatable-->
    {{-- <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('css') }}/bootstrap-extended.css" rel="stylesheet">
    <link href="{{ asset('css') }}/main.css" rel="stylesheet">
    <link href="{{ asset('css') }}/dark-theme.css" rel="stylesheet">
    <link href="{{ asset('css') }}/semi-dark.css" rel="stylesheet">
    <link href="{{ asset('css') }}/bordered-theme.css" rel="stylesheet">
    <link href="{{ asset('css') }}/custom.css" rel="stylesheet">
    <link href="{{ asset('css') }}/responsive.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!--start header-->
    @include('include.header')
    <!--end top header-->


    <!--start sidebar-->
    @include('include.sidebar')
    <!--end sidebar-->

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            @yield('content')
        </div>
    </main>
    <!--end main wrapper-->

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    <!--start footer-->
    @include('include.footer')
    <!--top footer-->


    <!--bootstrap js-->
    <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('js') }}/jquery.min.js"></script>
    <!--sweetalert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--datatable-->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('js') }}/perfect-scrollbar.js"></script>
    <script src="{{ asset('js') }}/metisMenu.min.js"></script>
    <script src="{{ asset('js') }}/apexcharts.min.js"></script>
    <script src="{{ asset('js') }}/index.js"></script>
    <script src="{{ asset('js') }}/jquery.peity.min.js"></script>
    <script src="{{ asset('js') }}/simplebar.min.js"></script>
    <script src="{{ asset('js') }}/main.js"></script>
    <script src="{{ asset('js') }}/custom.js"></script>
    <script>
        $(".data-attributes span").peity("donut");

         // ajax header setup
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // token
        var _token = "{{ csrf_token() }}";

        var table;

        // toastr alert message
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        function notification(status, message){
            Toast.fire({icon: status,title: message});
        }

        @if (Session::get('success'))
            notification('success',"{{ Session::get('success') }}")
        @elseif (Session::get('error'))
            notification('error',"{{ Session::get('error') }}")
        @elseif (Session::get('info'))
            notification('info',"{{ Session::get('info') }}")
        @elseif (Session::get('warning'))
            notification('warning',"{{ Session::get('warning') }}")
        @endif
    </script>

    @stack('scripts')
</body>


</html>
