@extends('layouts.app2')

@section('content')

<div class="mypage">

    {{-- プロフィール --}}
    <div class="profile-area">
        <div class="profile-icon"></div>

        <h2 class="user-name">
            ユーザー名
        </h2>

        <div class="profile-icon-area">
            <label for="profile_image" class="circle-icon">
                <img id="preview" 
                src="{{ Auth::user()->image
                ? Storage::url(Auth::user()->image)
                : asset('images/default.png') }}" alt="">
            </label>

        <a href="{{ route('mypage.profile') }}" class="edit-btn">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    <div class="tab-menu">
        <a href="?tab=sell" class="tab-link active">
            出品した商品
        </a>

        <a href="?tab=buy" class="tab-link">
            購入した商品
        </a>
    </div>

    {{-- 商品一覧 --}}
    <div class="item-list">

        <div class="item-card">
            <div class="item-image">商品画像</div>
            <p>商品名</p>
        </div>

        <div class="item-card">
            <div class="item-image">商品画像</div>
            <p>商品名</p>
        </div>

        <div class="item-card">
            <div class="item-image">商品画像</div>
            <p>商品名</p>
        </div>

        <div class="item-card">
            <div class="item-image">商品画像</div>
            <p>商品名</p>
        </div>

    </div>

</div>

@endsection