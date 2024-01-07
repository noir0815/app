<nav class="navbar navbar-expand-sm navbar-light shadow-sm fixed-top nagoyameshi-header-container" style="background-color: #FEFBFE;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('img/logo.png')}}" class="img-fluid header-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->

        <ul class="navbar-nav ms-auto mr-5 mt-2">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item mr-5">
                <a class="nav-link" href="{{ route('company') }}">
                    <i class="fa-regular fa-building"></i><label>会社概要</label>
                </a>
                <li class="nav-item mr-5">
                <a class="nav-link" href="{{ route('register') }}">
                    <i class="fa-solid fa-user-plus"></i><label>新規登録</label>
                </a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fa-solid fa-right-to-bracket"></i><label>ログイン</label>
                </a>
            </li>
            @else
                @if(auth()->user()->premium === 1)
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('company') }}">
                        <i class="fa-regular fa-building"></i><label>会社概要</label>
                    </a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('mypage') }}">
                        <i class="fas fa-user mr-1"></i><label>マイページ</label>
                    </a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('mypage.favorite') }}">
                        <i class="far fa-heart"></i><label>お気に入り</label>
                    </a>
                </li>
                @else
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('company') }}">
                        <i class="fa-regular fa-building"></i><label>会社概要</label>
                    </a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('mypage') }}">
                        <i class="fas fa-user mr-1"></i><label>マイページ</label>
                    </a>
                </li>
                @endif
            @endguest
      </ul>
    </div>
  </div>
</nav>