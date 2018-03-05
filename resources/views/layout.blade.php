<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="{{ URL::asset('assets/bower/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('assets/bower/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
</head>
<body>
    <div class="container">
        <header>
            @include('components.navbar')
            <ol class="breadcrumb">
                當前位置：@yield('breadcrumb')
            </ol>
        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>