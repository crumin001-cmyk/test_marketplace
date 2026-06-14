<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // メール未認証なら認証画面へ
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // 認証済なら初回ログイン画面へ
        return redirect()->route('firstLogin');
    }
}