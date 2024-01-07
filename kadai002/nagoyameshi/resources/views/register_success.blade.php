@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">{{ __('会員登録完了') }}</div>

                <div class="card-body">
                    {{ __('会員登録完了しました。') }}
                    （<a href="{{ url('/') }}">TOPページへ</a>）
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
