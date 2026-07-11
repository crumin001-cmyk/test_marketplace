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
            <input type="file" 
            id="profile_image" 
            name="profile_image"
            hidden
            >
            <label for="profile_image" class="circle-icon">
                画像を選択する
            </label>
            <img id="preview" src="" alt="">
        
        </div>
        <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            
            reader.onload = function(event) {
                const preview = document.getElementById('preview');
                preview.src = event.target.result;
                preview.style.display = 'block';
                document.querySelector('.circle-icon').style.display = 'none';
            };

                reader.readAsDataURL(file);
            });
        </script>

        <form action="{{ route('storeFirstLogin') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <label>ユーザー名</label>
            <input type="text" name="name" class="input" value="{{ old('name', $user->name) }}">

            <label>郵便番号</label>
            <input type="text" name="postal_code" class="input" value="{{ old('postal_code', $user->postal_code) }}">

            <label>住所</label>
            <input type="text" name="address" class="input" value="{{ old('address', $user->address) }}">

            <label>建物名</label>
            <input type="text" name="building" class="input" value="{{ old('building', $user->building) }}">
            
            <button type="submit" class="update-btn">
                更新する
            </button>

        </form>
    </div>
    @endsection