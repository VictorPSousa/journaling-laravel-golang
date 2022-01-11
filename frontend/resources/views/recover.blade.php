@include('/components/header')
@include('/components/navbar')

    <body class="recover">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-6 col-xs-5 align-form" action="">
                        <form action="{{ route('recovery') }}" id="form_recover" method="POST" class="recover-form">
                            @csrf
                            <div class="form-outline mb-4">
                                <h3 class="recover-text mb-3">Recuperação de senha</h3>
                                <p class="recover-text">Por favor, informe seu e-mail para prosseguir com a recuperação de senha.</p>
                                <hr>
                                <label class="form-label" for="recover_email" >E-mail</label>
                                <input type="email" id="recover_email" name="recover_email" maxlength="64" class="form-control" />
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <button type="submit" class="btn btn-block recover-btn mx-auto">Enviar</button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a class="btn btn-block recover-btn mx-auto" href="{{ url('login') }}">Voltar</a>
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
