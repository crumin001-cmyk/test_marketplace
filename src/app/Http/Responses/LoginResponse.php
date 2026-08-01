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
        // 初回プロフィール未登録ならプロフィール登録画面へ
        if (empty($user->postal_code) || empty($user->address)) {
            return redirect()->route('firstLogin');
        }

        // プロフィール登録済みなら商品一覧へ
        return redirect()->route('items.index');
    }
}
