@extends('layouts.app2')
@section('css')
<link rel="stylesheet" href="{{ asset('css/users_show.css') }}">
@endsection
@section('content')

<div class="mypage">

    {{-- プロフィール --}}
    <div class="profile-icon-area">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="image-form">
            @csrf

            <input type="file" name="image" id="profile_image" hidden>

            <label for="profile_image">
                <img
                    id="preview"
                    class="profile-icon"
                    src="{{ Auth::user()->image
                    ? Storage::url(Auth::user()->image)
                    : asset('images/default.png') }}"
                    alt="プロフィール画像">
            </label>

        </form>

    </div>
    <h2 class="user-name">
        ユーザー名
    </h2>

    <a href="{{ route('profile.edit') }}" class="edit-btn">
        プロフィールを編集
    </a>
</div>

{{-- タブ --}}
<div class="tab-menu">
    <a href="?page=sell" class="tab-text active">
        出品した商品
    </a>

    <a href="?page=buy" class="tab-text">
        購入した商品
    </a>
</div>

{{-- 商品一覧 --}}

<div class="item-list">
    @foreach($items as $item)
    <div class="item-card">
        <a href="{{ route('items.show', $item->id) }}">

            <div class="item-box">
                @if($item->image_path)
                <img
                    class="item-image"
                    src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                @else
                <span>商品画像</span>
                @endif
            </div>
            <p>{{ $item->name }}</p>
    </div>
    @endforeach
</div>

</div>

@endsection