@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <!-- 店舗詳細部分 -->
    <div class="row w-75 mt-5">
        <!-- レビュー投稿エラーの表示 -->
        <div class="row offset-1">
        @error('score')
            <p style="color:red;">・評価を選択してください</p><br>
        @enderror
        @error('content')
            <p style="color:red;" >・レビュー内容を200字以内で入力してください</p><br>
        @enderror
        @if(session('review'))
            <div class="alert alert-success">
            {{ session('review') }}
            </div>
        @endif
        </div>
        <!-- 店舗画像カラム -->
        <div class="col-md-5 col-sm-11 offset-1 mb-2">
            @if ($restaurant->image)
            <div class="thumbnail-box">
                <img src="{{ asset($restaurant->image) }}" class="img-thumbnail img-fluid custom-thumbnail">
            </div>
            @else
            <div class="thumbnail-box">
                <img src="{{ asset('img/noimage.png') }}" class="img-thumbnail img-fluid custom-thumbnail">
            </div>
            @endif
        </div>
        <!-- 店舗概要カラム -->
        <div class="col-md-6 co-sm-12">
            <div class="d-flex flex-column">
                <h1 class="">
                    {{$restaurant->name}}
                </h1>
                <h3 class="review-score-color">
                    {!! $restaurant->averageRatingWithStars() !!}
                    ({{ $restaurant->averageRating() }})
                </h3>

                <p class="">
                    　{{$restaurant->description}}
                </p>
                <hr>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th>平均価格帯</th>
                        <td>￥{{$restaurant->price}}(税込)</td>
                    </tr>     
                    <tr>
                        <th>郵便番号</th>
                        <td>〒{{$restaurant->postal_code}}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>{{$restaurant->address}}</td>
                    </tr>           
                    <tr>
                        <th>電話番号</th>
                        <td>{{$restaurant->phone_number}}</td>
                    </tr>                                                  
                </table>     
                <hr>
            </div>
            @if(auth()->check())
                <!-- 有料会員は予約とお気に入りができる -->
                @if($user->premium === 1)
                    <form method="POST" action="{{ route('restaurants.reservation', $restaurant->id) }}" class="m-3 align-items-end">
                        @csrf
                        <input type="hidden" name="id" value="{{ $restaurant->id }}">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <button type="submit" class="btn submit-button w-100">
                                    <i class="fa-solid fa-calendar-days"></i> 予約する
                                </button>
                            </div>
                            <div class="col-12 mt-2 mt-sm-0 col-sm-6">
                                @if($restaurant->isFavoritedBy(Auth::user()))
                                    <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn favorite-button text-favorite w-100">
                                        <i class="fa fa-heart"></i>
                                        お気に入り解除
                                    </a>
                                @else
                                    <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn favorite-button text-favorite w-100">
                                    <i class="fa fa-heart"></i>
                                    お気に入り
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <!-- 無料会員は予約はできるがお気に入りはできない -->
                    @else
                        <form method="POST" action="{{ route('restaurants.reservation', $restaurant->id) }}" class="m-3 align-items-end">
                            @csrf
                            <input type="hidden" name="id" value="{{ $restaurant->id }}">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <button type="submit" class="btn submit-button w-100">
                                        <i class="fa-solid fa-calendar-days"></i> 予約する
                                    </button>
                                </div>
                                <div class="col-12 mt-2 mt-sm-0 col-sm-6">
                                    @if($restaurant->isFavoritedBy(Auth::user()))
                                        <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn favorite-button text-favorite w-100 disabled">
                                            <i class="fa fa-heart"></i>
                                            お気に入り解除
                                        </a>
                                    @else
                                        <a href="{{ route('restaurants.favorite', $restaurant) }}" class="btn favorite-button text-favorite w-100 disabled">
                                        <i class="fa fa-heart"></i>
                                        お気に入り
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    @endif
                @else
                <!-- ゲストは予約、お気に入りボタンを押せない -->
                <div class="m-3 align-items-end">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <button type="button" class="btn submit-button w-100" disabled>
                                <i class="fas fa-shopping-cart"></i>
                                予約する
                            </button>
                        </div>
                        <div class="col-12 mt-2 mt-sm-0 col-sm-6">
                            <button type="button" class="btn favorite-button w-100" disabled>
                                <i class="fa fa-heart"></i>
                                お気に入り
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        
        <!-- レビュー表示・投稿 -->
        <div class="offset-1 col-11">
            <hr class="w-100">
        </div>
        <div>
            <h3 class="offset-1">カスタマーレビュー</h3>
        </div>

        <div class="offset-1 col-md-11 d-flex justify-content-start  flex-wrap">
            <div class="row col-md-6 d-flex justify-content-start">
            @foreach($reviews as $review)
                <div class="mb-4">
                    <label>{{$review->created_at}} {{$review->user->name}}</label>
                    {!! $restaurant->ratingStars($review->score) !!}
                    <p class="">{{$review->content}}</p>
                </div>
            @endforeach
                <!-- ページネーションリンクの表示 -->
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            </div>
            @auth
            <div class="row col-md-5 offset-1 d-flex align-self-start">
                <h3>レビューを書く</h3>
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <h5>評価</h5>
                    <select name="score" class="form-control my-4">
                        <option value="">選択してください</option>
                        <option value="5" class="review-score-color">⭐︎⭐︎⭐︎⭐︎⭐︎</option>
                        <option value="4" class="review-score-color">⭐︎⭐︎⭐︎⭐︎</option>
                        <option value="3" class="review-score-color">⭐︎⭐︎⭐︎</option>
                        <option value="2" class="review-score-color">⭐︎⭐︎</option>
                        <option value="1" class="review-score-color">⭐︎</option>
                    </select>
                    <h5>レビュー内容</h5>
                    <textarea name="content" class="form-control my-4" placeholder="レビューを記載してください"></textarea>
                    <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
                    <button type="submit" class="btn btn-primary ml-2">レビューを投稿</button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection