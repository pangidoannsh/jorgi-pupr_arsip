<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Manajemen Arsip PUPR</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('favicon.ico') }}" rel="icon" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href={{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/boxicons/css/boxicons.min.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/quill/quill.snow.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/quill/quill.bubble.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/remixicon/remixicon.css') }} rel="stylesheet">
    <link href={{ asset('assets/vendor/simple-datatables/style.css') }} rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href={{ asset('assets/css/style.css') }} rel="stylesheet">
    <link href={{ asset('assets/css/app.css') }} rel="stylesheet">
</head>

<body>
    @include('partials.header')
    @include('partials.navbar')
    @include('sweetalert::alert')

    <main id="main" class="main">

        <div class="pagetitle">
            <div
                class="position-relative d-flex {{ isset($isTitleCenter) && $isTitleCenter ? 'justify-content-center' : '' }}">
                <div class="title-prefix">
                    @stack('title-prefix')
                </div>
                <h1>{{ isset($title) ? $title : '' }}</h1>
            </div>
        </div><!-- End Page Title -->

        @yield('content')

    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <script src={{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}></script>
    <script src={{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('assets/vendor/chart.js/chart.umd.js') }}></script>
    <script src={{ asset('assets/vendor/echarts/echarts.min.js') }}></script>
    <script src={{ asset('assets/vendor/quill/quill.min.js') }}></script>
    <script src={{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}></script>
    <script src={{ asset('assets/vendor/tinymce/tinymce.min.js') }}></script>
    <script src={{ asset('assets/vendor/php-email-form/validate.js') }}></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Template Main JS File -->
    {{-- Datatable --}}
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    {{-- Sweetlalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src={{ asset('assets/js/main.js') }}></script>
    @stack('scripts')

</body>

</html>
