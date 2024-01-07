@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="top-body">
    <div class="top-search-container col-8 col-sm-6 col-md-4 col-lg-4">
        <form class="row g-3" action="{{route('restaurants.index')}}" method="GET">
            <div class="col-12">
                <input class="form-control nagoyameshi-header-search-input" name="keyword" placeholder="検索キーワードを入力">
            </div>
            <div class="col-9">
                <select name="category" class="form-select">
                    <option value="">カテゴリを選択</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 offset-1">
                <button type="submit" class="btn btn-primary nagoyameshi-header-search-button">
                    <i class="fas fa-search nagoyameshi-header-search-icon"></i>
                </button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
  // 画面スクロール時に検索バーの位置を中央に保持
  window.addEventListener('scroll', function() {
    var searchBarContainer = document.querySelector('.search-bar-container');
    searchBarContainer.style.top = Math.max(0, 50 - window.scrollY * 0.1) + '%';
  });
</script>

@endsection