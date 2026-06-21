<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
//use App\Http\Controllers\SellController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//fortifyのルーティング
//ログイン済
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back();
       })->name('verification.send'); 

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('firstLogin');
        })->middleware(['auth', 'signed'])
        ->name('verification.verify');//メール認証ルート
    
        //ログインかつメール認証済
    Route::middleware(['auth','verified'])->group(function() {
        Route::get('/firstlogin', [ProfileController::class, 'firstLogin'])
        ->name('firstLogin');
        
        Route::post('/firstlogin', [ProfileController::class, 'store'])
        ->name('storeFirstLogin');
        });
        Route::get('/', [ItemController::class, 'index'])->name('items.index');//商品一覧
        Route::post('/item/{item_id}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
        Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');//マイページ
        Route::get('//mypage/profile',[ProfileController::class, 'edit'])->name('mypage.profile');//マイページ編集
        Route::get('/sell', [SellController::class, 'create'])->name('sell');//出品
        Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');//商品詳細
        Route::post('/item/{item}/comment', [CommentController::class, 'store'])
        ->name('items.comment');

});
