@extends('layouts.app')

@section('content')

<div class="container">

<h1>新しい店舗を追加</h1>

    

    <form action="{{ route('restaurants.store') }}" method="POST">

    @csrf

        <div class="form-group">

        <label for="restaurant-name">店舗名</label>

            <input type="text" name="name" id="restaurant-name" class="form-control">

           </div>

        <div class="form-group">

        <label for="restaurantdescription">店舗説明</label>

            <textarea name="description" id="restaurant-description" class="form-control"></textarea>

           </div>

        <div class="form-group">

        <label for="restaurant-price">価格</label>

            <input type="number" name="price" id="restaurant-price" class="form-control">

           </div>

        <div class="form-group">

        <label for="restaurant-category">カテゴリ</label>

            <select name="category_id" class="form-control" id="restaurant-category">

            @foreach ($categories as $category)

                <option value="{{ $category->id }}">{{ $category->name }}</option>

                    @endforeach

               </select>

           </div>

        <button type="submit" class="btn btn-success">店舗を登録</button>

       </form>

    

    <a href="{{ route('restaurants.index') }}">店舗一覧に戻る</a>

   </div>

@endsection