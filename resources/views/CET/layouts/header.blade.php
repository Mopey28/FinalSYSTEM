<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Dashboard', 'Dashboard') }}</title>

    <link rel="icon" href="{{ asset('..\assets\ICON\CET-ICON.ico') }}" type="SSO ICON">

    <!-- Include AdminLTE CSS -->
    <link href="{{ asset('../dist/css/adminlte.min.css') }}" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <!-- Bootstrap CSS (If not already included) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Use Vite for JS and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
            
        .custom-sidebar-bg {
            background-image: url("{{ asset('assets/photos/SIDEBAR.png') }}");
            background-size: cover;
            background-position: center;
        }

        .content-wrapper {
            position: relative;
        }

        .content-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('assets/photos/CET.png') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.2;
        }
        
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('CET.layouts.navbar')

        <!-- Main Sidebar -->
        @include('CET.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Success and Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- Your page content will be yielded here -->
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer --> 

    </div>
    <!-- ./wrapper -->

    <!-- Include jQuery (Required by Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Include Popper.js (Required by Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Include AdminLTE JS (Optional if you're using AdminLTE) -->
    <script src="{{ asset('../dist/js/adminlte.min.js') }}"></script>

    

    <!-- Add extra scripts in specific views -->
    @stack('scripts')
 <!-- Script to auto-hide alerts after 2 seconds -->
 <script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 2000);

        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 2000);
    });
</script>
</body>

</html>
