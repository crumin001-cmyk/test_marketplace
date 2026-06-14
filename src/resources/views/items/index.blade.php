@extends('layouts.app2')

@section('content')

<div class="tab-menu">
    <a href="{{ route('items.index', ['tab' => 'recommend']) }}"
       class="tab-text {{ $tab === 'recommend' ? 'active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
       class="tab-text {{ $tab === 'mylist' ? 'active' : '' }}">
        マイリスト
    </a>
</div>

<div class="item-list">
    @foreach($items as $item)
        <div class="item-card">
            @if($item->sold_at)
            <span class="sold">Sold</span>//購入済ならSold表示
            @endif

            <div class="item-box">
                @if($item->image_path)
                    <img
                        class="item-image"
                        src="{{ asset('storage/' . $item->image_path) }}"
                        alt="{{ $item->name }}"
                    >
                @else
                    <p class="no-image-text">商品画像</p>
                @endif
            </div>

            <p class="item-name">{{ $item->name }}</p>

        </div>
    @endforeach
</div>
@endsection