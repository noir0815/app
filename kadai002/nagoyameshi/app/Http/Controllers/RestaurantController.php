<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;




class RestaurantController extends Controller
{

    // 店舗一覧ページの表示
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        // $categoryが文字列型であればCategoryモデルのインスタンスに変換
        if (is_string($category)) {
            $category = \App\Models\Category::find($category);
        }

        $query = \App\Models\Restaurant::sortable();
        if (!empty($category)) {
            $query->where('category_id', $category->id);
        }
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }
        // 各レストランの平均評価を計算して、$averageRatingsに格納
        $averageRatings = [];
        foreach ($query->get() as $restaurant) {
        $averageRatings[$restaurant->id] = $restaurant->reviews->avg('score');
        }
        $restaurants = $query->paginate(10);
        $total_count = $restaurants->total();
        $categories = \App\Models\Category::all();
        return view('restaurants.index', compact('restaurants', 'category', 'categories', 'total_count', 'keyword', 'averageRatings'));
    }

    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('restaurants.create',compact('categories'));
    // }

    // public function store(Request $request)
    // {
    //     $restaurant = new Restaurant();
    //     $restaurant->name =$request->input('name');
    //     $restaurant->description =$request->input('description');
    //     $restaurant->price =$request->input('price');
    //     $restaurant->category_id =$request->input('category_id');
    //     $restaurant->save();

    //     return to_route('restaurants.index');

    // }

    // 店舗詳細ページ
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        // レビューをページネーション付きで取得（1ページにつき5件）
        $reviews = $restaurant->reviews()->paginate(5);
        $user = Auth::user();

        return view('restaurants.show', compact('restaurant', 'reviews','user'));
    }

    public function edit(Restaurant $restaurant)
    {
        $categories = Category::all();

        return view('restaurants.edit',compact('restaurant','categories'));
    }


    public function update(Request $request, Restaurant $restaurant)
    {
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description');
        $restaurant->price = $request->input('price');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->update();

        return to_route('restaurants.index');
    }


    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return to_route('restaurants.index');
    }

    public function favorite(Restaurant $restaurant)
    {
        Auth::user()->togglefavorite($restaurant);
        
        return back();
    }
    //予約ページの表示
    public function reservation(Restaurant $restaurant)
    {
        //明日以降の３０日間を表示するセレクトボックスの配列
        $dates = [];
        $currentDate = now()->addDay(); // 現在の日時から1日進める（明日）
        $endDate = now()->addDays(30); // 30日後までの日付を表示する

        while ($currentDate->lte($endDate)) {
            $dates[$currentDate->format('Y-m-d')] = $currentDate->format('Y年m月d日 (D)');
            $currentDate->addDay();
        }

        //10:00から２２：００までの30分刻みを表示するセレクトボックスの配列
        $startTime = strtotime('10:00');
        $endTime = strtotime('22:00');
        $interval = 30 * 60; // 30分を秒に変換
        $times = [];
        for ($currentTime = $startTime; $currentTime <= $endTime; $currentTime += $interval) {
            $times[date('H:i', $currentTime)] = date('h:i A', $currentTime);
        }
        //1人から２０人までのセレクトボックスの配列
        $number_of_people =range(1,20);
        return view('restaurants.reservation',compact('restaurant','dates','times','number_of_people'));
    }
}
