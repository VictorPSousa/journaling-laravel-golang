@if(!session('email'))
    <p class="paragraph w-100">Para fazer uso desta funcionalidade faça login clicando no botão abaixo!</p>
    <a href="{{ url('/login' ) }}" class="btn-read-more">Login</a>
@endif
