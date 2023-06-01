<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Meta Title -->
        @if(isset($meta->title))
        <title>{{ $meta->title }} | Epic Revenue</title>
        @else
        <title>Epic Revenue</title>
        @endif

        <!-- Meta Description -->
        @if(isset($meta->description))
        <meta name="description" itemprop="description" content="{{ $meta->description }}" />
        @endif

        <!-- Meta Tags -->
        @if(isset($meta->keywords))
        <meta name="keywords" itemprop="keywords" content="{{ $meta->keywords }}" />
        @endif

        <!-- Icons -->
        <link rel="shortcut icon" type="image/png" href="{{ url('/assets/img/favicon.png') }}"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon.png">
        <link rel="shortcut icon" href="{{url('/images/favicon.ico')}}">
        <link rel="shortcut icon" type="image/png" href="{{url('/images/favicon.png')}}"/>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700;800;900&display=swap" rel="stylesheet">
        <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,700" rel="stylesheet" type="text/css">-->

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="{{ url('/assets/css/core.css') }}">
        <link rel="stylesheet" href="{{ url('/assets/css/app.css') }}">

        <!--<link rel="stylesheet" href="{{url('/assets/css/main.css')}}">-->
        @yield('styles')
    </head>
    <body @if(isset($activePage)) class="{{ $activePage }}" @endif @if(isset($bodyid))id="{{ $bodyid }}"@endif>

    <!-- Page Heading -->
    @include('shared/header')

    <!-- Page Content -->
    <div class="content-wrap">
    @yield('body')
    </div>

    <!-- Page Footer -->
    @include('shared/footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script type="text/javascript" src="{{ url('/assets/js/main.js') }}"></script>
    @yield('scripts')

    </body>
</html>
