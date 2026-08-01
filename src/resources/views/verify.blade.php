@extends('layouts.app')

@section('css')
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
        @if (session('status') === 'verification-link-sent')
        <p>認証メールを再送しました。</p>
        @else
        <a href="#"
            onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
            認証メールを再送する
        </a>
        @endif
    </div>
    <form id="resend-form" action="{{ route('verification.send') }}"
        method="POST"
        style="display: none;">
        @csrf
    </form>
</div>

@endsection