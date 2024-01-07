@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-9 col-md-6 mt-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 有料会員登録/解除
            </span>
            <h1 class="mt-3">有料会員登録/解除</h1>
            <hr>
            @if (empty($card))
            <h3>有料会員登録するにはクレジットカード情報を登録してください</h3>
            @endif

            <form action="{{ route('mypage.update_premium') }}" method="POST">
                @csrf
                @method('PUT')
                @if (!empty($card))
                    @if($user->premium === 0)
                    <p>あなたは現在無料会員です。</p>
                    <button type="submit" class="btn btn-success my-3">有料会員登録</button>
                    @else
                    <p>あなたは現在有料会員です。</p>
                    <button type="submit" class="btn btn-danger my-3">有料会員解除</button>
                    @endif
                @else
                @endif
            </form>
            <hr>
        </div>
    </div>
@endsection