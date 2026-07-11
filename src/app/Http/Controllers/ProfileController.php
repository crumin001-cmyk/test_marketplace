<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //初回プロフィール入力画面
    public function firstlogin()
    {
        $user = Auth::user();
        return view('firstlogin',compact('user'));
    }

    //初回プロフィール保存
    public function store(Request $request)
    {        
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address =$request->input('address');
        $user->building =$request->input('building');

        $user->save();
        return redirect()->route('items.index');
    }


    //マイページ画面_出品購入した商品一覧
    public function mypage(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');
        
        return view('mypage',compact('user','page'));
    }
    // プロフィール編集画面
    public function edit()
    {
        $user = auth()->user();

        return view('profile', compact('user'));

    }
    // 更新処理
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address =$request->input('address');
        $user->building =$request->input('building');

        $user->save();

        return redirect('mypage')->with('message', 'プロフィールを更新しました。');
    }
}
