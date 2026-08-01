@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases_create.css') }}">
@endsection

@section('content')
<form method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
    @csrf
    <div class="purchase-container">
        {{-- 左の画像 --}}

        <div class="purchase-left">

            <div class="item-info">
                @if($item->image_path)
                <div class="item-image">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
                </div>
                @else
                <div class="no-image">
                    商品画像
                </div>
                @endif
                <div class="item-detail">
                    <h2>{{ $item->name }}</h2>
                    <p>¥ {{ number_format($item->price) }}</p>
                </div>
            </div>

            <hr>

            <div class="payment-section">
                <h3>支払い方法</h3>

                <select name="payment_method" id="payment_method">
                    <option value="">選択してください</option>
                    <option value="convenience">コンビニ払い</option>
                    <option value="credit">カード払い</option>
                </select>
                @error('payment_method')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <div class="address-section">
                <div class="address-header">
                    <h3>配送先</h3>

                    <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
                </div>

                <div class="address-info">

                    <p>〒 {{ $address['postal_code'] }}</p>
                    <p>
                        {{ $address['address'] }}
                        {{ $address['building'] }}
                    </p>

                </div>

                <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
                @error('postal_code')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="hidden" name="address" value="{{ $address['address'] }}">
                @error('address')
                <p class="error">{{ $message }}</p>
                @enderror
                <input type="hidden" name="building" value="{{ $address['building'] }}">
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
                    <td id="payment-display">選択してください</td>
                </tr>
            </table>

            <button class="purchase-btn" type="submit">
                購入する
            </button>

        </div>

    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const select = document.getElementById('payment_method');
        const display = document.getElementById('payment-display');

        select.addEventListener('change', function() {
            display.textContent = this.options[this.selectedIndex].text;
        });

    });
</script>
@endsection