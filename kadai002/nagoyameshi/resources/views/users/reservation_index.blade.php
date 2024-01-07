@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="row justify-content-center mt-5">
        <div class="row col-9 col-lg-6 mt-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 予約情報一覧
            </span>
            <h1 class="mt-3">予約情報一覧</h1>
            <hr>
            <div class="row d-flex">
                @foreach ($reservations as $reservation)
                <form class="d-flex flex-wrap" method="get" action="{{route('restaurants.show',$reservation->restaurant->id)}}">
                    <div class="col-12 col-md-4">
                        @if ($reservation->restaurant->image !== "")
                        <div class="thumbnail-box">
                        <img src="{{ asset($reservation->restaurant->image) }}" class="img-thumbnail img-fluid custom-thumbnail">
                        </div>
                        @else
                        <div class="thumbnail-box">
                        <img src="{{ asset('img/noimage.png') }}" class="img-thumbnail img-fluid custom-thumbnail">
                        </div>
                        @endif
                    </div>
                    <div class="col-12  col-md-8  mt-3">
                        <table class="table table-bordered table-responsive col-5 offset-1 mt-3">
                            <tr>
                                <th>店舗名</th>
                                <td>{{$reservation->restaurant->name}}</td>
                            </tr>     
                            <tr>
                                <th>予約日時</th>
                                <td>{{$reservation->date}}  {{$reservation->time}}</td>
                            </tr>
                            <tr>
                                <th>予約人数</th>
                                <td>{{$reservation->num_of_ppl}}名</td>
                            </tr>                                                  
                        </table>     
                        <button type="submit" class="btn offset-1 my-4 btn-primary">店舗詳細</button>
                    </div>
                </form>
                <hr>
                @endforeach
            </div>
            {{ $reservations->links() }}
        </div>
    </div>
</div>
@endsection