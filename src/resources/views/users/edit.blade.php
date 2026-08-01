@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
<div class="profile-container">

    <h1 class="page-title">プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
        class="profile-form">
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



        <div class="form-group">
            <label>ユーザー名</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name ?? '') }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input
                type="text"
                name="postal_code"
                value="{{ old('postal_code', $user->postal_code ?? '') }}">
            @error('postal_code')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>住所</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $user->address ?? '') }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input
                type="text"
                name="building"
                value="{{ old('building', $user->building ?? '') }}">
        </div>

        <button type="submit" class="submit-btn">
            更新する
        </button>
</div>
</form>

</div>
@endsection