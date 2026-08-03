@extends('layouts.app2')
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="message">
    {{ session('message') }}
</div>
@endif

<div class="tab-menu">
    <a href="{{ route('items.index', [
    'tab' => 'recommend',
    'keyword' => request('keyword')
    ]) }}"
        class="tab-text {{ $tab === 'recommend' ? 'active' : '' }}">
        おすすめ
    </a>

    <a href="{{ route('items.index', [
    'tab' => 'mylist',
    'keyword' => request('keyword')
    ]) }}"
        class="tab-text {{ $tab === 'mylist' ? 'active' : '' }}">
        マイリスト
    </a>
</div>

<div class="item-list">
    @foreach($items as $item)
    <div class="item-card">

        <div class="item-box">
            @if($item->image_path)

            @if($item->purchase)
            <img
                class="item-image"
                src="{{ asset('storage/' . $item->image_path) }}"
                alt="{{ $item->name }}">
            <div class="sold">
                Sold
            </div>

            @else
            <a href="{{ route('items.show', $item->id) }}">
                <img
                    class="item-image"
                    src="{{ asset('storage/' . $item->image_path) }}"
                    alt="{{ $item->name }}">
            </a>
            @endif

            @else
            <p class="no-image-text">商品画像</p>
            @endif
        </div>

        <p class="item-name">{{ $item->name }}</p>

    </div>
    @endforeach
</div>
@endsection