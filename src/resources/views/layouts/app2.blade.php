<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    
    @yield('css')
</head>

<body class="body">
    <header class="header">

         {{-- ロゴ --}}
         <div class="header-logo">
            <img src="{{ asset('storage/COACHTECHヘッダーロゴ (4).png') }}" class="logo">
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="header-link logout-btn">
                            ログアウト
                        </button>
                    </form>
                </li>    

                        <li>
                            <a href="{{ route('mypage') }}" class="header-link mypage-btn">マイページ</a>
                        </li>
                        <li>
                        <a href="{{ route('sell.create') }}" class="header-link sell-btn">出品</a>
                        </li>
            </ul>
        </nav>
        @yield('header')
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>