@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/firstlogin.css') }}">
@endsection

@section('content')
<div class="firstlogin-container">
    <div class="firstlogin-box">
        <h2>プロフィール画面</h2>

        <div class="profile-icon-area">
            <label for="profile_image" class="circle-icon">
                <img id="preview" src="{{ asset('images/default.png') }}" alt="">
                画像を選択する
            </label>

            <input
                type="file"
                id="profile_image"
                name="profile_image"
                accept="image/*"
                hidden
            >
        </div>

        <form action="{{ route('storeFirstLogin') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <label>ユーザー名</label>
            <input type="text" class="input" value="{{ old('name', $user->name) }}">

            <label>郵便番号</label>
            <input type="text" class="input">

            <label>住所</label>
            <input type="text" class="input">

            <label>建物名</label>
            <input type="text" class="input">
            
            <button type="submit" class="update-btn">
                更新する
            </button>

        </form>
    </div>
    @endsection