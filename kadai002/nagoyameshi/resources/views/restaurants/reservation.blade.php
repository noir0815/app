@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-5 flex-wrap">
    <!-- 店舗情報 -->
    <div class="row w-75 mt-5">
        <!-- 店舗予約エラーの表示 -->
        <div class="row offset-1">
        @error('date')
            <p style="color:red;">・予約日を選択してください</p><br>
        @enderror
        @error('time')
            <p style="color:red;">・予約時間を選択してください</p><br>
        @enderror
        @error('num_of_ppl')
            <p style="color:red;">・予約人数を選択してください</p><br>
        @enderror
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
            </div>
        </div>
        <hr>
    </div>
    <!-- 予約機能 -->
    <div class="row w-75 mt-5 d-flex justify-content-between">
        <h3>店舗予約</h3>
        @auth
        <form method="POST" action="{{route('reservations.store')}}" class="m-3 align-items-end d-flex flex-wrap">
            @csrf
            <div class="offset-1 col-md-3 col-8 mt-2">
                <h5>日付</h5>
                <select name="date" class="form-control mt-2" id="date">
                    <option value="">選択してください</option>
                    @foreach($dates as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="offset-1 col-md-3 col-8 mt-2">
                <h5>時間</h5>
                <select name="time" class="form-control mt-2" id="time">
                    <option value="">選択してください</option>
                    @foreach($times as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="offset-1 col-md-3 col-8 mt-2">
            <h5>人数</h5>
            <select name="num_of_ppl" class="form-control mt-2" id="num_of_ppl">
                <option value="">選択してください</option>
                @foreach($number_of_people as $num_of_ppl)
                    <option value="{{$num_of_ppl}}">{{$num_of_ppl}}人</option>
                @endforeach
            </select>
            </div>
            <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
            <div class="btn submit-button offset-1 col-9 mt-5" data-bs-toggle="modal" data-bs-target="#buy-confirm-modal">予約を確定する</div>
            <!-- モーダルウィンドウ -->
            <div class="modal fade" id="buy-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">予約を確定しますか？</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn nagoyameshi-favorite-button border-dark text-dark" data-bs-dismiss="modal">閉じる</button>
                            <button type="submit" class="btn nagoyameshi-submit-button">予約</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endauth
    </div>
</div>
@endsection