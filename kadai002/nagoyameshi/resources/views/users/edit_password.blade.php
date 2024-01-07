@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-9 col-md-6 mt-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > パスワード変更
            </span>
            <h1 class="my-3">パスワードの変更</h1>
            <hr>
            <form method="post" action="{{route('mypage.update_password')}}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="col-md-3 col-form-label text-md-right">新しいパスワード</label>
                    </div>
                    <div class="row">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="password-confirm" class="col-md-3 col-form-label text-md-right">確認用</label>
                    </div>
                    <div class="row">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger mt-5">
                        パスワード更新
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection