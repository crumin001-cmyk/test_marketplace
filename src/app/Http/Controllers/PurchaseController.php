<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $address = session('purchase_address', [
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return view('purchases.create', compact('item', 'user', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        // すでに購入済みなら
        if ($item->sold_at) {
            return redirect()
                ->route('purchase.show', $item->id)
                ->with('message', 'この商品は購入済みです。');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
            'payment_method' => $request->payment_method,
        ]);
        // Sold状態にする
        $item->update([
            'sold_at' => now(),
        ]);

        return redirect()->route('items.index')
            ->with('message', 'お買い上げありがとうございます。');
    }

    public function edit($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('purchases.address', compact('item', 'user'));
    }

    public function update(AddressRequest $request, $item_id)

    {
        session([
            'purchase_address' => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ],
        ]);
        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}
