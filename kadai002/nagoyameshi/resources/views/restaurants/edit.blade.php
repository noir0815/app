@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>店舗情報更新</h1>

    <form action="{{ route('restaurants.update',$restaurant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="restaurant-name">店舗名</label>
            <input type="text" name="name" id="restaurant-name" class="form-control" value="{{ $restaurant->name }}">
        </div>
        <div class="form-group">
            <label for="restaurant-description">店舗説明</label>
            <textarea name="description" id="restaurant-description" class="form-control">{{ $restaurant->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="restaurant-price">価格</label>
            <input type="number" name="price" id="restaurant-price" class="form-control" value="{{ $restaurant->price }}">
        </div>
        <div class="form-group">
            <label for="restaurant-category">カテゴリ</label>
            <select name="category_id" class="form-control" id="restaurant-category">
                @foreach ($categories as $category)
                @if ($category->id == $restaurant->category_id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-danger">更新</button>
    </form>

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>
</div>
@endsection
