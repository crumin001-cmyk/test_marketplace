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
            
            <a href="{{ route('profile.edit') }}" class="edit-btn">
                プロフィールを編集
            </a>
        </div>
        
        {{-- タブ --}}
        <div class="page-menu">
            <a href="?page=sell" class="tab-link active">
                出品した商品
            </a>
            
            <a href="?page=buy" class="tab-link">
                購入した商品
            </a>
        </div>
        
        {{-- 商品一覧 --}}
        
        <div class="item-list">
            @foreach($items as $item)
            <div class="item-card">
                <a href="{{ route('items.show', $item->id) }}">
                    
            <div class="item-image">
                @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                @endif
            </div>
            <p>{{ $item->name }}</p>
        </div>
        @endforeach
    </div>

</div>

@endsection