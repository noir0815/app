<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Restaurant extends Model
{
    use HasFactory,Favoriteable,Sortable;

    //レストランは１つのカテゴリを持つ
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //レストランは多数のレビューを持つ
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 平均評価を小数第一位まで取得
    public function averageRating()
    {
        $average = $this->reviews->avg('score');
        return round($average, 1); // 平均を小数第一位で四捨五入
    }

    // 平均評価を星で表示（画像）
    public function averageRatingWithStars()
    {
        $average = $this->reviews->avg('score');
        $integerPart = floor($average); // 整数部分
        $decimalPart = round(($average - $integerPart) * 10) / 10; // 小数部分（四捨五入）

        $stars = '';
        
        // 整数部分の星を追加
        for ($i = 0; $i < $integerPart; $i++) {
            $stars .= '<img src="' . asset('img/star-on.png') . '" alt="star">';
        }

        // 小数部分に応じて星を追加
        if ($decimalPart > 0) {
            // 小数第一位が5以上ならstar-half.pngを表示
            if ($decimalPart >= 0.5) {
                $stars .= '<img src="' . asset('img/star-half.png') . '" alt="star">';
            }
        }
        return $stars;
    }

    // レビュー評価を星で表示（画像）
    public function ReviewRatingWithStars()
    {
        $average = $this->reviews->avg('score');
        $integerPart = floor($average); // 整数部分
        $decimalPart = round(($average - $integerPart) * 10) / 10; // 小数部分（四捨五入）

        $stars = '';
        
        // 整数部分の星を追加
        for ($i = 0; $i < $integerPart; $i++) {
            $stars .= '<img src="' . asset('img/star-on.png') . '" alt="star">';
        }

        // 小数部分に応じて星を追加
        if ($decimalPart > 0) {
            // 小数第一位が5以上ならstar-half.pngを表示
            if ($decimalPart >= 0.5) {
                $stars .= '<img src="' . asset('img/star-half.png') . '" alt="star">';
            }
        }
        return $stars;
    }

    //レストランは多数の予約を持つ
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // レビュースコアの星を生成するメソッド
    public function ratingStars($score)
    {
        $integerPart = floor($score);
        $decimalPart = round($score - $integerPart, 2);

        $stars = '';

        for ($i = 1; $i <= $integerPart; $i++) {
            $stars .= '<img src="' . asset('img/star-on.png') . '" alt="star">';
        }

        if ($decimalPart >= 0.5) {
            $stars .= '<img src="' . asset('img/star-half.png') . '" alt="half-star">';
        }

        return $stars;
    }
    //平均評価でのソート
    public function reviewSortable($query, $direction){
        return $query->withAvg('reviews','score')->orderBy('reviews_avg_score',$direction);
    }

}
