<header class="market-header header" style="padding-bottom: 10px;">
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="/assets/front/images/version/market-logo.png" alt=""></a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Cinema</a>
                    </li>
                    @if (session()->has('tokenlogin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('films.create') }}">Добавить фильм</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('endpoint') }}">Endpoint</a>
                    </li>
                    <li class="nav-item rightcol" style="position: absolute; right: 0;">
                        <a class="nav-link" href="{{ route('logout') }}">Выйти</a>
                    </li>

                    @else
                        <li class="nav-item right" style="pos">
                            <a class="nav-link" href="{{ route('loginForm') }}">Авторизация</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div><!-- end container-fluid -->
</header><!-- end market-header -->

