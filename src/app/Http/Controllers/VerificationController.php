<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Requests\verifiedRequest;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('verify');
    }
    public function verify(EmailVerificationRequest $request)
    {
    $request->fulfill();

    return redirect()->route('firstLogin');
    }
}