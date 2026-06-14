@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <div class="register-box">

        <h2>会員登録</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">    
                <label>メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" id="password" name="password">
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">確認用パスワード</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="register-button">登録する</button>

            <div class="form-link">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection