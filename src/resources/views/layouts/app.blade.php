<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">

    @yield('css')
</head>

<body class="body">
    <header class="header">
        <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" class="logo">
        @yield('header')
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>