<!DOCTYPE html>
<html ng-app="admin">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Epic Revenue</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/ui/trumbowyg.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
    
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}" data-hs-appearance="default"as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/app.css') }}" data-hs-appearance="default"as="style">

    @yield('styles')
    <!--<link rel="stylesheet" href="{{ url('/assets/css/admin.css') }}">-->
</head>

<body>
    @include('admin.shared.angular-header')
    <div class="content-wrap">
        <div class="container-fluid">
            <div class="row">
                @include('admin.shared.sidebar')
                <div class="col-lg-10 col-sm-12">
                    <!-- Content -->
                    <div class="content py-3">
                        @yield('body')
                    </div>
                    @include('admin.shared.footer')
                </div>
            </div>
        </div>
    </div>

<!-- JS Global Compulsory  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.0/jquery-migrate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS Front -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.1.0/trumbowyg.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
<script type="text/javascript" src="{{ url('/assets/js/admin.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/admin-angular.js') }}"></script>

@yield('scripts')

</body>
</html>
