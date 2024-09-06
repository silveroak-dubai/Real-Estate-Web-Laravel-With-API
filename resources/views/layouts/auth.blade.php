<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('settings.site_title') ? config('settings.site_title') : config('app.site_title') }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('img') }}/favicon-32x32.png" type="image/png">
    <!--bootstrap css-->
    <link href="{{ asset('css') }}/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('css') }}/main.css" rel="stylesheet">

</head>

<body class="bg-login vh-100" style="background-image: url({{ asset('img') }}/bg-login.png)">
    <!--authentication-->
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4 mx-auto">
                <div class="card">
                    @yield('content')
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <!--authentication-->


    <!--plugins-->
    <script src="{{ asset('js') }}/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });
    </script>

</body>

<!-- Mirrored from codervent.com/matoxi/demo/vertical-menu/auth-basic-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Jun 2024 06:15:49 GMT -->

</html>
