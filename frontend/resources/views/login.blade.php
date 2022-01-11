@include('/components/header')
@include('/components/navbar')

        <main class="principal-form-login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 bg-img-login h-vh-100 px-5 py-5">
                        <h1 class="display-3 pt-4 text-average">Entrar no Orgen</h1>
                        <h2 class="w-75 login-subtitle">Faça login para aproveitar todas as funcionalidades</h2>
                    </div>
                    <div class="col-xs-12 col-md-6 central-form">
                        <form action="{{ route('enter') }}" id="form_login" method="POST" class="col-xl-8 login-form">
                            @csrf
                            <div class="col-lg-10 mx-auto">
                                <div class="title-form text-center">
                                    <h3 class="display-4 text-average">Orgen</h3>
                                </div>
                                @include('/components/alert')
                                @include('/components/validate-errors')

                                <div class="form-outline mb-3">
                                    <label class="form-label" for="email">Usuário</label>
                                    <input type="email" id="email" name="email" minlength="6" maxlength="64" class="form-control" value="{{ old('email') }}" required/>
                                </div>
                                <div class="form-outline mb-3">
                                    <label class="form-label" for="pass">Senha</label>
                                    <input type="password" id="pass" name="pass" minlength="8" maxlength="24" class="form-control" required />
                                </div>
                                <div class="row ml-1 pt-1">
                                    <p>Ainda não possui uma conta? <a href="{{ url('/register' ) }}">Cadastre-se.</a></p>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto">Entrar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-primary btn-block btn-recover mx-auto" href="{{ url('/recover') }}">Recuperar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
