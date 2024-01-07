<div class="container mt-5">
    <h3>カテゴリ</h3>
    @foreach ($categories as $category)
        <label class="nagoyameshi-sidebar-category-label mb-1"><a href="{{route('restaurants.index',['category'=>$category->id])}}">{{ $category->name }}</a></label><br>
    @endforeach
</div>