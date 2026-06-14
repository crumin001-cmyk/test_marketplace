<?php

//namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests\LoginRequest;

//class LoginController extends Controller

    //public function loginView()
    
        //return view('login');
    

    //public function login(Request $request)
    {
    
        // バリデーション
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 認証
        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

        return redirect('/')->with('message', 'ログインしました。');
        }

        return back()->withErrors(['email' => 'ログイン情報が登録されていません。',
        ])->withInput();
    }

        //public function logout(Request $request)
        {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('message', 'ログアウトしました。');
        }

?>