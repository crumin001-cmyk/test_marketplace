@extends('layouts.app2')

@section('content')

<h1>商品の出品</h1>

<form action="" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="image">

    <input type="text" name="name" placeholder="商品名">

    <textarea name="description"></textarea>

    <input type="number" name="price">

    <button type="submit">
        出品する
    </button>

</form>

@endsection