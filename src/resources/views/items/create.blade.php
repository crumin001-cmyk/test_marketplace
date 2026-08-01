@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items_create.css') }}">
@endsection

@section('content')
<div class="sell-container">

    <h1 class="page-title">商品の出品</h1>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label class="section-title">商品画像</label>

            <div class="image-upload">
                <input type="file" name="image" id="image" hidden>
                <label for="image" class="upload-btn">
                    画像を選択する
                </label>
                <img id="preview" src="">
                <script>
                    document.getElementById('image').addEventListener('change', function(e) {
                        const file = e.target.files[0];

                        if (!file) return;

                        const reader = new FileReader();

                        reader.onload = function(event) {
                            const preview = document.getElementById('preview');
                            preview.src = event.target.result;
                            preview.style.display = 'block';
                            document.querySelector('.upload-btn').style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    });
                </script>

            </div>

            @error('image')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品詳細 --}}
        <div class="form-section">
            <h2 class="sub-title">商品の詳細</h2>

            <label>カテゴリー</label>

            <div class="category-list">
                @foreach($categories as $category)
                <label class="category-tag">
                    <input type="checkbox"
                        name="categories[]"
                        value="{{ $category->id }}">
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
                @error('categories')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <label>商品の状態</label>
            <select name="condition_id">
                <option value="">選択してください</option>

                @foreach($conditions as $condition)
                <option value="{{ $condition->id }}"
                    {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                    {{ $condition->name }}
                </option>
                @endforeach

            </select>
            @error('condition_id')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品名と説明 --}}
        <div class="form-section">
            <h2 class="sub-title">商品名と説明</h2>

            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror

            <label>ブランド名</label>
            <input type="text" name="brand" value="{{ old('brand') }}">

            <label>商品の説明</label>
            <textarea name="description" rows="5">{{ old('description')}}"</textarea>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror

            <label>販売価格</label>
            <div class=" price-wrapper">
                <span class="yen"></span>
                <input type="number"
                    name="price"
                    min="0"
                    value="{{ old('price') }}">
            </div>
            @error('price')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="submit-btn">
            出品する
        </button>

    </form>
</div>
@endsection