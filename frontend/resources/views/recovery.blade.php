@include('/components/header')
@include('/components/navbar')

    <body class="recover">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-6 col-xs-5 align-form" action="">
                        <form action="{{ route('recover_access') }}" id="form_recovery" method="POST" class="recover-form">
                            @csrf
                            <div class="form-outline mb-4">
                                <h3 class="recover-text mb-3">Recuperação de acesso</h3>
                                <p class="recover-text">Por favor, informe seu e-mail para prosseguir com a recuperação de senha.</p><hr>
                                @include('/components/validate-errors')
                                <label class="form-label" for="recover_email" >E-mail</label>
                                <input type="email" id="recover_email" name="recover_email" maxlength="64" class="form-control" required />

                                <label class="form-label mt-3" for="recover_pass" >Nova Senha</label>
                                <input type="password" id="recover_pass" name="recover_pass" minlength="8" maxlength="24" class="form-control" required />

                                <label class="form-label mt-3" for="recover_pass_confirm" >Confirme a Senha</label>
                                <input type="password" id="recover_pass_confirm" name="recover_pass_confirm" minlength="8" maxlength="24" class="form-control" required />

                                <div class="row justify-content-center mt-4">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-block recover-btn mx-auto">Enviar</button>
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
