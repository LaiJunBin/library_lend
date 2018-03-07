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
        <footer class="page-footer font-small blue pt-4 mt-4 text-center">
            由資料處理科賴俊賓製作<a class="github-button" href="https://github.com/xyz607xx" aria-label="Follow @xyz607xx on GitHub">GitHub</a>
            <a class="github-button" href="https://github.com/xyz607xx/library_lend" aria-label="Watch ntkme/github-buttons on GitHub">Watch</a>
            <script src="https://buttons.github.io/buttons.js"></script>
            <script src="https://buttons.github.io/buttons.js"></script>
            <script>
                $(function(){
                    $("footer iframe").css('vertical-align','top');
                    window.onresize = function(){
                        $("footer").css('width',$(this).width());
                    }
                    $("footer").css('width',$(this).width());
                })
            </script>
        </footer>
    </div>
</body>
</html>