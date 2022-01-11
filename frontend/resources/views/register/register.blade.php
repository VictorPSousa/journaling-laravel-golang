@include('/components/header')
@include('/components/navbar')

    <body class="register">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-10 align-form mb-5" action="">
                        <form class="register-form" action="{{ route('register_user') }} "  method="POST">
                            @csrf
                            <div class="form-outline mb-4">
                                @include('/components/validate-errors')

                                <h3 class="mb-3 text-center">Cadastre-se</h3>                               
                                <hr>

                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="nome">Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome" minlength="2" maxlength="32" value="{{ old('nome') }}" required/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="sobrenome" >Sobrenome</label>
                                        <input type="text" class="form-control" name="sobrenome" id="sobrenome" minlength="2" maxlength="32" value="{{ old('sobrenome') }}" required/>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="email" >E-mail</label>
                                        <input type="email" class="form-control email" name="email" id="email" minlength="6" maxlength="64" value="{{ old('email') }}" required/>
                                    </div>                                    
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="senha" >Senha</label>
                                        <input type="password" class="form-control" name="senha" id="senha" minlength="8" maxlength="24" required/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="rsenha" >Repetir Senha</label>
                                        <input type="password" class="form-control rsenha" name="rsenha" id="rsenha" minlength="8" maxlength="24" required/>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3 mb-3 container-fluid">
                                        <button type="submit" id="btn-submit" class="btn btn-block register-btn mx-auto">Salvar</button>
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