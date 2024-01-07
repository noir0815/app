<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;




class UserController extends Controller
{
    //mypageの表示
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    //会員情報ページの表示
    public function edit()
    {
        $user = Auth::user();
 
        return view('users.edit', compact('user'));
    }

    //会員情報の更新
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), 
            ],
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        $user->postal_code = $request->input('postal_code') ? $request->input('postal_code') : $user->postal_code;
        $user->address = $request->input('address') ? $request->input('address') : $user->address;
        $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
        $user->update();

        return to_route('mypage')->with('update', '会員ステータスが更新されました。');
    }

    // パスワードの変更
    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage')->with('password_update', 'パスワードが更新されました。');
    }

    //パスワード変更ページの表示
    public function edit_password()
    {
        return view('users.edit_password');
    }

    //お気に入りページの表示
    public function favorite()
    {
        $user = Auth::user();
        $favorites = $user->favorites(Restaurant::class)->get();

        return view('users.favorite', compact('favorites'));
    }

    //予約一覧の表示
    public function reservation_index(Request $request)
    {
        $user =Auth::user();
        $reservations = Reservation::with('restaurant')->where('user_id',$user->id)->paginate(10);

        return view('users.reservation_index',compact('reservations'));
    }

    //退会
    public function destroy(Request $request)
    {
        Auth::user()->delete();

        return redirect('/');
    }

    // クレジットカード登録ページの表示
    public function register_card(Request $request)
    {
        $user = Auth::user();

        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $card = [];
        $count = 0;

        if ($user->token != "") {
            $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit"=>1))->data[0];
            $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;

            $card = [
                'brand' => $result["brand"],
                'exp_month' => $result["exp_month"],
                'exp_year' => $result["exp_year"],
                'last4' => $result["last4"] 
            ];
        }
        return view('users.register_card', compact('card', 'count'));
    }

    // クレジットカードの登録
    public function token(Request $request)
    {
        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $user = Auth::user();
        $customer = $user->token;

        if ($customer != "") {
            $cu = \Payjp\Customer::retrieve($customer);
            $delete_card = $cu->cards->retrieve($cu->cards->data[0]["id"]);
            $delete_card->delete();
            $cu->cards->create(array(
                "card" => request('payjp-token')
            ));
        } else {
            $cu = \Payjp\Customer::create(array(
                "card" => request('payjp-token')
            ));
            $user->token = $cu->id;
            $user->update();
        }

        return to_route('mypage')->with('card', 'クレジットカード情報が更新されました。');
    }

    // 有料会員登録ページの表示
    public function premium (Request $request)
    {
        $user = Auth::user();

        $pay_jp_secret = env('PAYJP_SECRET_KEY');
        \Payjp\Payjp::setApiKey($pay_jp_secret);

        $card = [];
        $count = 0;

        if ($user->token != "") {
            $result = \Payjp\Customer::retrieve($user->token)->cards->all(array("limit"=>1))->data[0];
            $count = \Payjp\Customer::retrieve($user->token)->cards->all()->count;

            $card = [
                'brand' => $result["brand"],
                'exp_month' => $result["exp_month"],
                'exp_year' => $result["exp_year"],
                'last4' => $result["last4"] 
            ];
        }

        return view('users.premium', compact('card', 'count','user'));
    }
    // 有料/無料会員更新
    public function updatePremium(Request $request)
    {
        // 現在のユーザーを取得
        $user = Auth::user();

        // premium カラムの値をトグル（0なら1に、1なら0に）
        $user->update(['premium' =>!$user->premium]);

        return redirect()->route('mypage')->with('update', '会員ステータスが更新されました。');
    }

}
