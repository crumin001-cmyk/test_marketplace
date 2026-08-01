@extends('layouts.app2')

@section('css')
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
            {{ $item->brand }}
        </p>

        {{-- 価格 --}}
        <p class="price">
            ¥{{ number_format($item->price) }}
            <span>（税込）</span>
        </p>
        <div class="action-icons">

            {{-- いいね --}}
            <div class="favorite-area">

                @if($item->favoriteUsers->contains(auth()->id()))

                {{-- いいね解除 --}}
                <form action="{{ route('favorite.destroy', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="favorite-btn">
                        <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="">
                    </button>
                </form>

                @else

                {{-- いいね登録 --}}
                <form action="{{ route('favorite.store', $item) }}" method="POST">
                    @csrf

                    <button type="submit" class="favorite-btn">
                        <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="">
                    </button>
                </form>

                @endif

                <p>{{ $item->favoriteUsers->count() }}</p>

            </div>
            {{-- コメント --}}
            <div class="comment-area">
                <img src="{{ asset('images/ふきだしロゴ.png') }}">

                <p>{{ $item->comments->count() }}</p>
            </div>

        </div>

        @if(!$item->sold_at)
        <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="buy-button">
            購入手続きへ
        </a>
        @else
        <div class="sold">
            Sold
        </div>
        @endif

        <h3>商品説明</h3>
        <p class="description">
            {{ $item->description }}
        </p>

        <h3>商品の情報</h3>
        <div class="info-row">
            <span class="label">カテゴリー</span>
            <div class="category-values">
                @foreach($item->categories as $category)
                <span class="value">
                    {{ $category->name }}
                </span>
                @endforeach
            </div>
        </div>
        <div class="info-row">
            <span class="label">商品の状態</span>
            <span class="condition">
                {{ $item->condition->name }}
            </span>

        </div>

        <h3>コメント({{ $item->comments->count() }})</h3>

        @foreach($item->comments as $comment)
        <div class="comment">
            <img
                src="{{ $comment->user->image
                    ? Storage::url($comment->user->image)
                    : asset('images/default.png') }}"
                alt="">

            <p class="comment-user">{{ $comment->user->name }}</p>

            <p class="comment-body">
                {{ $comment->content }}
            </p>
        </div>
        @endforeach

        <h4>商品へのコメント</h4>

        <form action="{{ route('items.comment', $item) }}" method="POST">
            @csrf

            <textarea name="content" class="comment-input"></textarea>

            <button type="submit" class="comment-btn">コメントを送信する</button>
        </form>
    </div>
</div>
</div>
@endsection