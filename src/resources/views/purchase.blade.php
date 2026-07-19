@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    {{-- 左の画像 --}}
        <div class="item-image-area">
            
                @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}"
                alt="商品画像"
                class="item-image">
                @else
                <div class="no-image">
                    商品画像
                </div>
                @endif
            </a>
        </div>

    {{-- 左側 --}}
    <div class="purchase-left">

        <div class="item-info">
            <div class="item-image">
                <img src="{{ asset('images/noimage.png') }}" alt="">
            </div>

            <div class="item-detail">
                <h2>{{ $item->name }}</h2>
                <p>¥ {{ number_format($item->price) }}</p>
            </div>
        </div>

        <hr>

        <div class="payment-section">
            <h3>支払い方法</h3>

            <select name="payment_method">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="credit">カード払い</option>
            </select>
        </div>

        <hr>

        <div class="address-section">
            <div class="address-header">
                <h3>配送先</h3>
                
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
            </div>

            <div class="address-info">
                <p>〒 {{ $user->postal_code }}</p>
                <p>
                    {{ $user->address }}
                    {{ $user->building }}
                </p>
            </div>
        </div>

        <hr>

    </div>

    {{-- 右側 --}}
    <div class="purchase-right">

        <table class="purchase-table">
            <tr>
                <th>商品代金</th>
                <td>¥ {{ number_format($item->price) }}</td>
            </tr>

            <tr>
                <th>支払い方法</th>
                <td>コンビニ払い</td>
            </tr>
        </table>


        <form method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
            @csrf
            <button class="purchase-btn">
                購入する
            </button>
        </form>
    </div>

</div>
@endsection