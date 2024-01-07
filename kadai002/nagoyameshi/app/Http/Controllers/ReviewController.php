<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    //レビューの投稿
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:200',
            'score' => 'required'
        ]);

        $review = new Review();
        $review->score = $request->input('score');
        $review->content = $request->input('content');
        $review->restaurant_id = $request->input('restaurant_id');
        $review->user_id = Auth::user()->id;
        $review->save();

        return back()->with('review', 'レビューを投稿しました。');
   }
}
