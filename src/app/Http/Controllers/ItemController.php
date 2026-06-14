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
        $items = Item::all();
        
        if ($tab === 'mylist') {
            $items = Item::whereHas('favorite', function ($query) {
                $query->where('user_id', auth()->id());
                })->get();
                
        } else {

        $items = Item::query();
        //自分の商品は除外する
        if (Auth::check()) {
            $items->where('user_id', '!=', Auth::id());
        }
            
            $items = $items->get();
    }
    
    return view('items.index', compact('items', 'tab'));
    }
}
