@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/layout1.css') }}">
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item_contener">
        {{-- 左の画像 --}}
        <div class="item-image-area">
            
                @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}"
                alt="商品画像"
                class="item-image">
                @else
                <div class="no-image">
                    商品画像
                </div>
                @endif
            </a>
        </div>

        {{-- 右側詳細 --}}
        <div class="item-info">
            {{-- 商品名がここに入ります --}}
            <h2 class="item-name">
                {{ $item->name }}
            </h2>

            {{-- ブランド名 --}}
            <p class="brand-name">
            {{ $item->brand?->name }}
            </p>

            {{-- 価格 --}}
            <p class="price">
                ¥{{ number_format($item->price) }}
                <span>（税込）</span>
            </p>
            {{-- いいね--}}
            <div class="icon_area">
                <img src="{{ asset('storage/ハートロゴ_デフォルト.png') }}" 
                id="site-logo"
                onclick="changeLogo()">
                
                <p>0</p>
            </div>
            {{-- コメント --}}
            <div class="comment-area">
                <img src="{{ asset('storage/ふきだしロゴ.png') }}" >

                <p>0</p>
            </div>    
            <script>
                function changeLogo() {
                    const logo = document.getElementById('site-logo');
                    // 現在の画像名に logo1 が含まれているか判定
                    if (logo.src.includes('ハートロゴ_デフォルト.png')) {
                        logo.src = "{{ asset('storage/ハートロゴ_ピンク.png') }}";
                    } else {
                        logo.src = "{{ asset('storage/ハートロゴ_デフォルト.png') }}";
                    }
                }
            </script>
            <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="buy-button">
                購入手続きへ
            </a>

            <h3>商品説明</h3>
            <p class="description">
                {{ $item->description }}
            </p>

            <h3>商品の情報</h3>
            <div class="info">
                <span class="label">カテゴリー</span>
                @foreach($item->categories as $category)
                <span class="value">
                    {{ $category->name }}
                </span>
                 @endforeach

                <span class="label">商品の状態</span>
                <span class="value">
                    {{ $item->condition->name }}
                </span>
        
            </div>

            <h3>コメント</h3>
            <div class="comment">
                <p class="comment-user">admin</p>
                <p class="comment-body">こちらにコメントが入ります。</p>
            </div>
            <form action="{{ $item->id }}" method="POST">
            @csrf
            <textarea name="comment">商品へのコメント</textarea>

            <button type="submit">コメントを送信する</button>
        </div>
    </div>
</div>
@endsection