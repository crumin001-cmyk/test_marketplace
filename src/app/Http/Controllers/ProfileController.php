<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    //初回プロフィール入力画面
    public function firstlogin()
    {
        $user = Auth::user();
        return view('firstlogin', compact('user'));
    }

    //初回プロフィール保存
    public function store(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('upload_users', 'public');
            $user->image = $image_path;
        }
        $user->save();
        return redirect()->route('items.index');
    }


    //マイページ画面_出品購入した商品一覧
    public function mypage(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        $items = collect();

        if ($page === 'sell') {
            //出品した商品
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($page === 'buy') {
            //購入した商品
            $items = Item::whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $items = collect();
        }
        return view('users.show', compact('user', 'page', 'items'));
    }

    // プロフィール編集画面
    public function edit()
    {
        $user = auth()->user();

        return view('users.edit', compact('user'));
    }
    // 更新処理
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('upload_users', 'public');
            $user->image = $image_path;
        }
        $user->save();

        return redirect('mypage')->with('message', 'プロフィールを更新しました。');
    }
}
