<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
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

Route::get('/', [ItemController::class, 'index'])->name('items.index'); //商品一覧
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show'); //商品詳細
//fortifyのルーティング
//ログイン済
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('firstLogin');
    })->middleware(['auth', 'signed'])
        ->name('verification.verify'); //メール認証ルート

    //ログインかつメール認証済
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/firstlogin', [ProfileController::class, 'firstLogin'])
            ->name('firstLogin');

        Route::post('/firstlogin', [ProfileController::class, 'store'])
            ->name('firstlogin.store');
    });

    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage'); //マイページ
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create'); //出品
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

    Route::post('/item/{item}/favorite', [FavoriteController::class, 'store'])
        ->middleware('auth')->name('favorite.store'); //いいね
    Route::delete('/item/{item}/favorite', [FavoriteController::class, 'destroy'])
        ->middleware('auth')->name('favorite.destroy');
    Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])
        ->name('items.comment');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit'); //マイページ編集
    Route::post('/mypage/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update'); //マイページ更新
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show'); //商品購入
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'edit'])->name('address.edit'); //住所変更
    Route::put('/purchase/address/{item_id}', [PurchaseController::class, 'update'])->name('purchase.address.update');
    Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/{item_id}/cancel', [PurchaseController::class, 'cancel'])
        ->name('purchase.cancel');
});
