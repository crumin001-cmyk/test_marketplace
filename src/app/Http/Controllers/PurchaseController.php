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
        // 支払い方法をStripe用に変換
        if ($request->payment_method === 'credit') {
            $paymentMethodType = 'card';
        } elseif ($request->payment_method === 'convenience') {
            $paymentMethodType = 'konbini';
        } else {
            return back()
                ->withErrors([
                    'payment_method' => '支払い方法を選択してください。',
                ])
                ->withInput();
        }

        // Stripe Checkout Sessionを作成
        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
        );

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',

            'payment_method_types' => [
                $paymentMethodType,
            ],

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',

                        'product_data' => [
                            'name' => $item->name,
                        ],

                        'unit_amount' => $item->price,
                    ],

                    'quantity' => 1,
                ],
            ],

            'customer_email' => Auth::user()->email,

            'success_url' => route('purchase.success', [
                'item_id' => $item->id,
            ]),

            'cancel_url' => route('purchase.cancel', [
                'item_id' => $item->id,
            ]),
        ]);

        return redirect($session->url);

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

    public function success($item_id)
    {
        return redirect()
            ->route('items.index')
            ->with('message', 'Stripe決済画面での手続きが完了しました。');
    }

    public function cancel($item_id)
    {
        return redirect()
            ->route('purchase.show', ['item_id' => $item_id])
            ->with('message', '決済がキャンセルされました。');
    }
}
