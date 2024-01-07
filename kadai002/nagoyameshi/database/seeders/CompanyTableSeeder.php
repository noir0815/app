<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;


class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'company_name' => '名古屋飯株式会社',
            'president' =>'名古屋愛',
            'establishment_date' =>'2000年1月1日',
            'postal_code' =>'〒460-0031',
            'address' =>'愛知県名古屋市中区本丸１−１',
            'phone' =>'000-000-0000',
            'description'=>'名古屋飯株式会社はnagoyameshiの運営会社です。名古屋飯株式会社はnagoyameshiの運営会社です。名古屋飯株式会社はnagoyameshiの運営会社です。名古屋飯株式会社はnagoyameshiの運営会社です。名古屋飯株式会社はnagoyameshiの運営会社です。'
        ]);    }
}
