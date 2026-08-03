@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/firstlogin.css') }}">
@endsection

@section('content')
<div class="firstlogin-container">
    <div class="firstlogin-box">
        <h2>プロフィール画面</h2>




        <form action="{{ route('firstlogin.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-width">

                <div class="image-area">
                    <img id="preview" src="" alt="" class="profile-icon">

                    <label for="image" class="image-btn">
                        画像を選択する
                    </label>

                    <input type="file" name="image" id="image" hidden>
                </div>
            </div>
            <script>
                document.getElementById('image').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = function(event) {
                        document.getElementById('preview').src = event.target.result;
                    };

                    reader.readAsDataURL(file);

                });
            </script>

            <label>ユーザー名</label>
            <input type="text" name="name" class="input" value="{{ old('name', $user->name) }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror

            <label>郵便番号</label>
            <input type="text" name="postal_code" class="input" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
            <p class="error">{{ $message }}</p>
            @enderror
            <label>住所</label>
            <input type="text" name="address" class="input" value="{{ old('address', $user->address) }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror

            <label>建物名</label>
            <input type="text" name="building" class="input" value="{{ old('building', $user->building) }}">

            <button type="submit" class="update-btn">
                更新する
            </button>

        </form>
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
    </div>
    @endsection