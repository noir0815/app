@extends('layouts.app')

@section('content')
<div class="container  d-flex justify-content-center mt-3">
    <div class="row justify-content-center mt-5">
        <div class="row col-9 mt-5">
            <span>
                <a href="{{ route('restaurants.index') }}">トップ</a> > お気に入り一覧
            </span>
            <h1 class="mt-3">お気に入り一覧</h1>
            <hr>
            <div class="row d-flex">
                @foreach ($favorites as $fav)
                <div class="d-flex flex-wrap mt-2">
                    <div class="col-12 col-md-4">
                        @if (App\Models\Restaurant::find($fav->favoriteable_id)->image !== "")
                        <div class="thumbnail-box">
                            <img src="{{ asset(App\Models\Restaurant::find($fav->favoriteable_id)->image) }}" class="img-thumbnail img-fluid custom-thumbnail" >
                        </div>
                        @else
                        <div class="thumbnail-box">
                            <img src="{{ asset('img/noimage.png') }}" class="img-thumbnail img-fluid custom-thumbnail">
                        </div>
                        @endif
                    </div>
                    <div class="col-12  col-md-8  mt-2">
                        <table class="table table-bordered table-responsive offset-lg-1 mt-3">
                            <tr>
                                <th>店舗名</th>
                                <td>{{App\Models\Restaurant::find($fav->favoriteable_id)->name}}</td>
                            </tr>     
                            <tr>
                                <th>平均価格帯</th>
                                <td>&yen;{{App\Models\Restaurant::find($fav->favoriteable_id)->price}}</td>
                            </tr>
                            <tr>
                                <th>予約人数</th>
                                <td>名</td>
                            </tr>                                                  
                        </table>
                        <div class="d-flex flex-wrap col-12 justify-content-lg-center">
                            <div class="col-10 mt-2">
                                <a href="{{route('restaurants.show',App\Models\Restaurant::find($fav->favoriteable_id)->id)}}" class="btn btn-primary w-100">
                                <i class="fa-solid fa-store"></i>
                                店舗詳細
                                </a>
                            </div>
                            <div class="col-10 mt-2">
                                <a href="{{ route('restaurants.reservation',App\Models\Restaurant::find($fav->favoriteable_id)->id) }}" class="btn submit-button w-100">
                                <i class="fa-solid fa-calendar-days"></i> 予約する
                                </a>
                            </div>
                            <div class="col-10 my-2">
                                <a href="{{ route('restaurants.favorite',  $fav->favoriteable_id) }}" class="btn favorite-button w-100">
                                    <i class="fa fa-heart"></i>
                                    お気に入り解除
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection