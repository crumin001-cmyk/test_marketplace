@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
            </div>

            <label>商品の状態</label>
            <select name="condition_id">
                <option value="">選択してください</option>

                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 商品名と説明 --}}
        <div class="form-section">
            <h2 class="sub-title">商品名と説明</h2>

            <label>商品名</label>
            <input type="text" name="name">

            <label>ブランド名</label>
            <input type="text" name="brand">

            <label>商品の説明</label>
            <textarea name="description" rows="5"></textarea>

            <label>販売価格</label>
            <div class="price-wrapper">
                <span class="yen">¥</span>
                <input type="number" name="price">
            </div>
        </div>

        <button type="submit" class="submit-btn">
            出品する
        </button>

    </form>
</div>
@endsection