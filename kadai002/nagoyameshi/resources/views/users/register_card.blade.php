@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-9 col-md-6 mt-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > クレジットカードの登録
            </span>
            <h1 class="mt-3">クレジットカード情報</h1>
            <hr>
            @if (!empty($card))
            <h3>登録済みのクレジットカード</h3>

            <h4>{{ $card["brand"] }}</h4>
            <p>有効期限: {{ $card["exp_year"] }}/{{ $card["exp_month"] }}</p>
            <p>カード番号: ************{{ $card["last4"] }}</p>
            @endif

            <form action="{{ route('mypage.token') }}" method="post">
                @csrf
                @if (empty($card))
                <script type="text/javascript" src="https://checkout.pay.jp/" class="payjp-button" data-key="{{ ENV('PAYJP_PUBLIC_KEY') }}" data-on-created="onCreated" data-text="カードを登録する" data-submit-text="カードを登録する"></script>
                @else
                <script type="text/javascript" src="https://checkout.pay.jp/" class="payjp-button" data-key="{{ ENV('PAYJP_PUBLIC_KEY') }}" data-on-created="onCreated" data-text="カードを更新する" data-submit-text="カードを更新する"></script>
                @endif
            </form>
            <hr>
        </div>
    </div>
@endsection