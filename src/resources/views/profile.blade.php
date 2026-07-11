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
    
        <div class="image-area">
            <div class="profile-icon">

            </div>

            <input type="file" name="image" id="image" hidden>

            <label for="image" class="image-btn">
                画像を選択する
            </label>
            <img id="preview" src="" alt="">
            <script>
                document.getElementById('image').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        const preview = document.getElementById('preview');
                        preview.src = event.target.result;
                        preview.style.display = 'block';
                        document.querySelector('.image-btn').style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                });
            </script>

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
                name="postal_code"
                value="{{ old('postal_code', $user->postal_code ?? '') }}"
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