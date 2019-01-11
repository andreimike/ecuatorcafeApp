<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Acasa') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Font Awesome 5.5.0 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- FavIcon -->
    <link rel="icon" sizes="192x192"
          href="https://ecuatorcafe.ro/wp-content/uploads/2018/10/Logo-EcuatorCafeEdited.jpg">
    <!-- Meta Tag Manager -->
    <meta name="theme-color" content="#C7A17A"/>
    <!-- / Meta Tag Manager -->
    <style>
        .nightMode > div {
            background-color: #343a40 !important;
        }

        .displayNone {
            display: none;
        }
    </style>
</head>
<body>
<div id="app">
    @include('inc.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @include('inc.footer')
</div>
<!--JS Scripts -->

</body>
</html>
