<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchase', compact('item', 'user'));
    }

    public function store(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        // すでに購入済みなら
        if ($item->sold_at) {
            return redirect()
            ->route('items.show', $item->id)
            ->with('message', 'この商品は購入済みです。');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
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
        return view('address.edit', compact('item','user'));
    }
    
    public function update(Request $request, $item_id)
    {
        $user = Auth::user();
        $user->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building
        ]);
        return redirect()->route('purchase.show', ['item_id' => $item_id]);

    }
}