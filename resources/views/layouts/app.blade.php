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
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    {{-- Select 2 --}}
    <link href="{{ asset('/') }}css/select2.min.css" rel="stylesheet" />
    <!--bootstrap css-->
    <link href="{{ asset('css') }}/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- datatable-->
    <link href="{{ asset('/') }}css/responsive.bootstrap4.min.css" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('css') }}/bootstrap-extended.css" rel="stylesheet">
    <link href="{{ asset('css') }}/main.css" rel="stylesheet">
    <link href="{{ asset('css') }}/dark-theme.css" rel="stylesheet">
    <link href="{{ asset('css') }}/semi-dark.css" rel="stylesheet">
    <link href="{{ asset('css') }}/bordered-theme.css" rel="stylesheet">
    <link href="{{ asset('css') }}/custom.css" rel="stylesheet">
    <link href="{{ asset('css') }}/responsive.css" rel="stylesheet">
    <style>
        .flatpickr-calendar {
            top: 234.4px !important;
        }
        table.table{
            width: 100% !important;
        }
        input::placeholder,
        textarea::placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        input::-webkit-input-placeholder,
        textarea::-webkit-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        input::-moz-placeholder,
        textarea::-moz-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        input:-ms-input-placeholder,
        textarea:-ms-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        input::-ms-input-placeholder,
        textarea::-ms-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        input:-o-input-placeholder,
        textarea:-o-input-placeholder {
            color: #999;
            font-size: 14px;
            font-weight: normal;
        }

        .btn{
            border-radius: 0 !important;
            font-size: 13px;
            font-weight: normal;
        }

        .select2-results__option {
            color: #333;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            color: #333;
        }
        table thead tr th {
            font-weight: 400 !important;
            font-size: 13px !important;
        }
        .modal-title {
            font-size: 1.1rem;
        }
        .swal2-popup.swal2-toast {
            padding: .5em 1em !important;
        }
        .swal2-popup.swal2-toast .swal2-title {
            font-size: .8em !important;
            line-height: 2 !important;
        }
        .swal2-popup.swal2-toast .swal2-icon {
            margin: 0 !important;
        }
    </style>
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

    <!--plugins-->
    <script src="{{ asset('js') }}/jquery.min.js"></script>
    <!--bootstrap js-->
    <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
    <!--sweetalert2-->
    <script src="{{ asset('js') }}/sweetalert2@11.js"></script>
    <!--datatable-->
    <script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}js/dataTables.buttons.min.js"></script>
    {{-- Select 2 --}}
    <script src="{{ asset('js') }}/select2.min.js"></script>
    {{-- datarange --}}
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.min.js') }}"></script>
    {{-- flatpickr --}}
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    {{-- toastr --}}
    <script src="{{ asset('js/toastr.min.js') }}"></script>
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

        // sweetalert message
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // toastr alert
        function toastr_alert(status, message) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "500",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            switch (status) {
                case 'success':
                    toastr.success(message);
                    break;

                case 'error':
                    toastr.error(message);
                    break;

                case 'warning':
                    toastr.warning(message);
                    break;

                case 'info':
                    toastr.info(message);
                    break;
            }
        }

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

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    @stack('scripts')
</body>


</html>
