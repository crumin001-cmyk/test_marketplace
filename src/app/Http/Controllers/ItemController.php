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
        
        if ($tab === 'mylist') {
            $items = Item::whereHas('favoriteUsers', function ($query) {
                $query->where('user_id', auth()->id());
                })->get();
                
        } else {

        $items = Item::query();
        //自分の商品は除外する
        if (Auth::check()) {
            $items->where('user_id', '!=', Auth::id());
        }
            
            $items = Item::all();
        }
    
    return view('items.index', compact('items', 'tab'));
    }

    public function favorite($item_id)
    {
        Auth::user()->favorite()->syncWithoutDetaching([$item_id]);
        return back();
    }

    public function show(Item $item) 
    {
        $item->load('comments.user');
        return view('items.show', compact('item')); 
    } 
    
    //public function comments() 
    //{
        //return $this->hasMany(Comment::class); 
    //}

    //public function comment(Request $request, Item $item)
    //{
        //
    //}

}