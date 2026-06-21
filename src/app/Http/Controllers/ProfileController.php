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
        return redirect()->route('items.index');
    }


    //マイページ
    public function mypage()
    {
        $user = Auth::user();
        return view('mypage',compact('user'));
    }
    // プロフィール編集画面
    //public function edit()
    //{
        //$user = auth()->user();
        //return view('mypage.profile', ['user' => $user]);
    //}
    // 更新処理
    //public function update(Request $request)
    //{
        //$user = auth()->user();
        //$user->name = $request->input('name');
        //$user->save();

        //return redirect('/mypage/profile')->with('message', 'プロフィールを更新しました。');
    //}
}
