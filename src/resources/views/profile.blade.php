@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">

    <h1 class="page-title">プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
    </form>
    
        <div class="image-area">
            <div class="profile-icon"></div>

            <input type="file" name="image" id="image" hidden>

            <label for="image" class="image-btn">
                画像を選択する
            </label>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input
                type="text"
                name="postcode"
                value="{{ old('postcode', $user->postcode ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label>住所</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $user->address ?? '') }}"
            >
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input
                type="text"
                name="building"
                value="{{ old('building', $user->building ?? '') }}"
            >
        </div>

        <button type="submit" class="submit-btn">
            更新する
        </button>

    </form>

</div>
@endsection