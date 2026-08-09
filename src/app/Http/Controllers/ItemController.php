<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {

            if (!Auth::check()) {
                $items = Item::whereRaw('1 = 0');
            } else {
                $items = Item::whereHas('favoriteUsers', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            }
        } else {

            $items = Item::query();

            // ログイン中のみ自分の商品を除外
            if (Auth::check()) {
                $items->where('user_id', '!=', Auth::id());
            }
        }
        // おすすめ・マイリスト共通で検索
        if (!empty($keyword)) {
            $items->where('name', 'like', '%' . $keyword . '%');
        }

        $items = $items->get();


        return view('items.index', compact('items', 'tab', 'keyword'));
    }


    public function show(Item $item)
    {
        $item->load('favoriteUsers');
        return view('items.show', compact('item'));
    }
}
