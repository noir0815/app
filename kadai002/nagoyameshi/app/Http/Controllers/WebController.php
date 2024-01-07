<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class WebController extends Controller
{
    // トップページの表示
    public function index()
    {
        $restaurants =Restaurant::all();
        $categories = Category::all();

        return view('web.index', compact('categories','restaurants'));
    }    
}
