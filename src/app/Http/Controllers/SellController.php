<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $image_path=$request->image->store('upload_items','public');
        Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'brand_id' => $request->brand_id,
            'condition_id' => $request->condition_id,
            'image_path'=>$image_path,
        ]);

        return redirect()->route('mypage', ['page'=>'sell']);
    }
}