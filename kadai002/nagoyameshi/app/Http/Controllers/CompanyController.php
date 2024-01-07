<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    // 会社情報ページ
    public function index()
    {
        $companies = Company::get()->toArray();
        $company =$companies[0];

        return view('web.company',compact('company'));
    }
}
