<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/app2.css') }}">

    @yield('css')
</head>

<body class="body">
    <header class="header">
        <div class="header-inner">

            {{-- ロゴ --}}
            <div class="header-logo">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" class="logo">
            </div>

            {{-- 検索フォーム --}}
            <div class="header-search">
                <form action="{{ route('items.index') }}" method="GET">
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="なにをお探しですか？" class="search-input">
                </form>
            </div>
            {{-- ナビ --}}
            <nav class="header-nav">
                <ul class="nav-list">
                    <li>
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header-link logout">
                                ログアウト
                            </button>
                        </form>
                        @endauth

                        @guest
                        <a href="{{ route('login') }}" class="header-link">
                            ログイン
                        </a>
                        @endguest
                    </li>

                    <li>
                        <a href="{{ route('mypage') }}" class="header-link mypage-btn">マイページ</a>
                    </li>
                    <li>
                        <a href="{{ route('sell.create') }}" class="sell-btn">出品</a>
                    </li>
                </ul>
            </nav>
            @yield('header')
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>