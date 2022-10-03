<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NSS Retail</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/backend.css?v=1.0.0')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/remixicon/fonts/remixicon.css')}}"> </head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

    @include('frontend.layouts.sidebar')
    @include('frontend.layouts.topbar')

    @yield('content')

</div>
<!-- Wrapper End-->
{{-- <footer class="iq-footer">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="../backend/privacy-policy.html">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="../backend/terms-of-service.html">Terms of Use</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="mr-1"><script>document.write(new Date().getFullYear())</script>©</span> <a href="#" class="">POS Dash</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
<!-- Backend Bundle JavaScript -->
<script src="{{ asset('dashboard/assets/js/backend-bundle.min.js')}}"></script>

<!-- Table Treeview JavaScript -->
<script src="{{ asset('dashboard/assets/js/table-treeview.js')}}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('dashboard/assets/js/customizer.js')}}"></script>

<!-- Chart Custom JavaScript -->
<script async src="{{ asset('dashboard/assets/js/chart-custom.js')}}"></script>

<!-- app JavaScript -->
<script src="{{ asset('dashboard/assets/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</body>

</html>