<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        let homeUrl = '{{ asset("storage") }}';
        console.log(homeUrl);
    </script>
    <script src="{{ asset('js/search.js') }}" defer></script>
    <script src="{{ asset('js/delete.js') }}" defer></script>
    <script type="text/javascript" src="C:\Users\mk114\OneDrive\デスクトップ\lesson\jquery-3.7.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <main class="py-4 mb-5">
            @yield('content')
            @yield('scripts')
        </main>
</body>
</html>