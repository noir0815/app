@extends('layouts.app')

@section('content')
<!-- 店舗一覧表示ページ -->
<div class="row mt-5">
    <!-- サイドバー -->
    <div class="col-md-2 d-none d-md-block">
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
    </div>
    <!-- パンくずリスト、検索バー、ソート表示部分 -->
    <div class="col-12 col-md-9 mt-5" style="padding-left:40px;">
        <div class="container container-fluid">
            <h2 class="mb-2">店舗一覧</h2>
            <!-- トップへのリンク -->
            <a href="{{ route('restaurants.index') }}">トップ</a>            
            <!-- カテゴリとキーワードが共に指定された場合のリンク -->
            @if (!empty($category) && !empty($keyword))
                ><a href="{{ route('restaurants.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                ><a href="{{ route('restaurants.index', ['keyword' => $keyword]) }}">{{ $keyword }}</a>
                <h2>「{{ $category->name }}」カテゴリの中で「{{ $keyword }}」で検索した結果 {{$total_count}} 件</h2>
            <!-- カテゴリのみが指定された場合のリンク -->
            @elseif (!empty($category))
                ><a href="{{ route('restaurants.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                <h2>「{{ $category->name }}」カテゴリの中で検索した結果 {{$total_count}} 件</h2>
            <!-- キーワードのみが指定された場合のリンク -->
            @elseif (!empty($keyword))
                ><a href="{{ route('restaurants.index', ['keyword' => $keyword]) }}">{{ $keyword }}</a>
                <h2>「{{ $keyword }}」で検索した結果 {{$total_count}} 件</h2>
            @endif
        </div>
        <!-- ソート順の表示 -->
        <div class="mt-2 container container-fluid">
            @sortablelink('price', '価格で並び替える')
            @sortablelink('review', '評価で並び替える')
        </div>
        <!-- 検索バー・カテゴリセレクト -->
        <div class="container mt-2">
            <form class="row  col-11 justify-content-between justify-content-sm-end" action="{{route('restaurants.index')}}" method="GET">
                <div class="col-12 col-sm-auto">
                    <input class="form-control nagoyameshi-header-search-input" name="keyword" placeholder="検索キーワードを入力">
                </div>
                <div class="col-8 col-sm-auto">
                    <select name="category" class="form-control">
                        <option value="">カテゴリを選択</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ optional($category)->id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 offset-1 offset-sm-0 col-sm-auto">
                    <button type="submit" class="btn nagoyameshi-header-search-button">
                        <i class="fas fa-search nagoyameshi-header-search-icon"></i>
                    </button>
                </div>
            </form>
        </div>
        <hr>
        <!-- 店舗一覧表示部分 -->
        <div class="container d-flex  flex-wrap  justify-content-between  align-items-start mt-4 ">
            @foreach($restaurants as $restaurant)
            <div class="row col-lg-4 col-md-6 col-12 rounded border-light d-flex justify-content-center mb-3">
                <div class="bg-body-secondary pt-1 pb-1" style="max-width: 400px;">
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="d-flex justify-content-center">
                        @if ($restaurant->image !== "")
                        <div class="thumbnail-box">
                        <img src="{{ asset($restaurant->image) }}" class="img-thumbnail img-fluid custom-thumbnail">
                        </div>
                        @else
                        <div class="thumbnail-box">
                        <img src="{{ asset('img/noimage.png') }}" class="img-thumbnail img-fluid custom-thumbnail">
                        </div>
                        @endif
                    </a>
                </div>
                <div class="bg-body-secondary" style="max-width: 400px;">
                    <h2>{{ $restaurant->name }}</h2><br>
                    <p>{{ $restaurant->category->name }}</p>
                    <p>平均価格帯　￥{{ $restaurant->price }}</p><br>
                    <p>平均評価:{!! $restaurant->averageRatingWithStars() !!}({{ $restaurant->averageRating() }})</h3><br>
                </div>
            </div>
            @endforeach
        </div>
        {{ $restaurants->appends(request()->input())->links() }}
    </div>

</div>
@endsection