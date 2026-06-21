<?php

//namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests\RegisterRequest;

//class RegisterController extends Controller
{
    //public function registerView()
    {
        //return view('register');
    }

    //public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ユーザーの作成
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // ログイン
        auth()->login($user);

        $user->sendEmailVerificationNotification();

        // メール認証画面へリダイレクト
        //return redirect()->route('verified.notice');
    }
}
