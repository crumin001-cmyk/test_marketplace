<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;


class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $image_path = $request->image->store('upload_items', 'public');
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'brand' => $request->brand,
            'condition_id' => $request->condition_id,
            'image_path' => $image_path,
        ]);
        $item->categories()->sync($request->categories);

        return redirect()->route('mypage', ['page' => 'sell']);
    }
}
