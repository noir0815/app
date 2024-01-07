<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;



//TOPページ
Route::get('/',  [WebController::class, 'index'])->name('top');
//会社情報ページの表示
Route::get('company',  [CompanyController::class, 'index'])->name('company');
//レビューの保存
Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
//予約の保存
Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
//お気に入り追加
Route::get('restaurants/{restaurant}/favorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');
//予約ページの表示
Route::match(['get', 'post'], 'restaurants/{restaurant}/reservation', [RestaurantController::class, 'reservation'])->name('restaurants.reservation');
// マイページ
Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        //パスワード変更
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password'); 
        //お気に入り管理
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        //予約一覧の表示
        Route::get('users/mypage/reservation/index', 'reservation_index')->name('mypage.reservation_index');
        //退会画面
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
        // 決済機能
        Route::get('users/mypage/register_card', 'register_card')->name('mypage.register_card');
        Route::post('users/mypage/token', 'token')->name('mypage.token');
        // 有料会員登録
        Route::get('users/mypage/premium', 'premium')->name('mypage.premium');
        Route::put('users/mypage/premium', 'updatePremium')->name('mypage.update_premium');
    });
});

Route::resource('restaurants',RestaurantController::class);

Auth::routes(['verify'=>true]);
// 会員登録完了
Route::get('register_success', [App\Http\Controllers\HomeController::class, 'index'])->name('register_success');


