<nav class="navbar">
    <div class="form-inline my-2 my-lg-0">
        <!-- menu hamburger desktop -->
        <div class="nav-link " id="navbarDropdowns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="hamburger align-self-center"></i>
        </div>

        <!-- menu hamburger mobile -->
        <button class="navbar-toggler" id="navbarMobile" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="hamburger align-self-center"></i>
        </button>

        <div class="navbar-brand"><img src="{{asset('img/logo.png')}}"></div>
        <div class="title">Orgen</div>

        <!-- dropdown mobile -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="@if(session('email'))
                                                                    {{ url('user/dashboard') }}
                                                                @else
                                                                    {{ url('/' ) }}
                                                                @endif">Home</a></li>
                @if(!session('nome'))
                    <li class="nav-item active"><a class="nav-link" href="{{ url('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('register') }}">Cadastro</a></li>
                @endif
                @if(session('nome'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/schedule') }}">Agenda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/notes') }}">Notas e Listas</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/dashboard') }}"><i class="fas fa-at mr-2"></i>{!! session('email') !!}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/myaccount') }}"><i class="fas fa-user mr-2"></i>Minha conta</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('logout') }}"><i class="fas fa-sign-out-alt mr-2"></i> Sair</a></li>
                @endif
            </ul>
        </div>

        <!-- dropdown desktop -->
        <div class="dropdown-menu" aria-labelledby="navbarDropdowns">
            @if(!session('nome'))
                <a class="dropdown-item" href="{{ url('login') }}">Login</a>
                <a class="dropdown-item" href="{{ url('register') }}">Cadastro</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/') }}">Home</a>
            @endif
            @if(session('nome'))
                <a class="dropdown-item" href="{{ url('user/dashboard') }}">Home</a>
                <a class="dropdown-item" href="{{ url('user/schedule') }}">Agenda</a>
                <a class="dropdown-item" href="{{ url('user/notes') }}">Notas e Listas</a>
            @endif
        </div>
    </div>

    <!-- dropdown user -->
    @if(session('nome'))
        <div class="navbar-text user">
            <span class="mr-1" id="icon-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></span>
            <span class="msg-user">Olá, {!! session('nome') !!}!</span>

            <div class="dropdown-menu dropdown-user" aria-labelledby="icon-user">
                <a class="dropdown-item nome-user" href="{{ url('user/dashboard') }}">
                    {!! session('nome') !!}
                </a>
                <a class="dropdown-item" href="{{ url('user/dashboard') }}">{!! session('email') !!}</a>
                <a class="dropdown-item" href="{{ url('user/myaccount') }}">Minha conta</a>
                <a class="dropdown-item logout-user" href="{{ url('logout') }}">Sair<div class="icon-logout"><i class="fas fa-sign-out-alt"></i></div></a>
            </div>
        </div>
    @endif

</nav>
