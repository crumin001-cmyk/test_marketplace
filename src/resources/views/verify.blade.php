@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="verify-container">
    <div class="verify-box">
        <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p>メール認証を完了してください。</p>
        
        <div class="form-button">
            <a href="http://localhost:8025" class="verify-button">
                    認証はこちらから
            </a>
        </div>
    </div>
    
    <div class="form-link">
        <div class="form-link" onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
            認証メールを再送しました。
        </div>
    </div>
</div>

@endsection