@include('/components/header')
@include('/components/navbar')

<body class="my-account">
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 align-form" action="">
                    <div class="my-account-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="senha-tab" href="#senha"  data-toggle="tab"  role="tab" aria-controls="senha" aria-selected="false">Senha</a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" id="name-tab" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="true">Nome</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delete-tab" data-toggle="tab" href="#delete" role="tab" aria-controls="delete" aria-selected="false">Deletar Conta</a>
                            </li>
                        </ul>
                        <div class="tab-content">      
                            <div class="tab-pane fade show active" id="senha" role="tabpanel" aria-labelledby="senha-tab">
                                @if(!Session::has('next-step'))
                                    <form class="account-form" action="{{ route('confirm_pass') }}" method="POST">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <h3 class="text-center mb-3">Alterar senha</h3>
                                            <p class="text-center">Confirme sua senha atual para poder prosseguir</p>
                                            <hr>
                                            @include('/components/alert')
                                            <div class="row mt-3">
                                                <div class="col-md-6 mb-3 container-fluid">
                                                    <label class="form-label" for="senha">Senha atual</label>
                                                    <input type="password" class="form-control form-account" name="old_pass" id="old_pass" placeholder="Insira a sua senha atual" />
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3 mb-3 container-fluid">
                                                    <button type="submit" id="btn-pass" class="btn btn-block btn-confirm mx-auto">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form class="account-form" action="{{ route('edit_pass') }}" method="POST">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <h3 class="text-center mb-3">Alterar senha</h3>
                                            <p class="text-center">Preencha os campos com a sua nova senha</p>
                                            <hr>
                                            @include('/components/validate-errors')
                                            <div class="row mt-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="new_pass">Senha nova</label>
                                                    <input type="password" class="form-control form-account" name="senha" id="senha" placeholder="Insira a nova senha" />
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="rsenha">Confirmar senha nova</label>
                                                    <input type="password" class="form-control form-account" name="rsenha" id="rsenha" placeholder="Confirme a nova senha" />
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3 mb-3 container-fluid">
                                                    <button type="submit" id="btn-pass" class="btn btn-block account-btn mx-auto">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>  
                                @endif
                            </div>     
                            <div class="tab-pane fade" id="name" role="tabpanel" aria-labelledby="name-tab">
                                <form class="account-form" action="{{ route('edit_user') }}" method="POST">
                                    @csrf
                                    <div class="form-outline mb-4">
                                        <h3 class="text-center mb-3">Alterar informações pessoais</h3>
                                        <hr>
                                        @include('/components/alert')
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="nome">Nome</label>
                                                <input type="text" class="form-control form-account" name="nome" id="nome" minlength="2" maxlength="32" value="{!! session('nome') !!}" required/>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="email">Sobrenome</label>
                                                <input type="text" class="form-control form-account email" name="sobrenome" id="email" minlength="2" maxlength="32" value="{!! session('sobrenome') !!}" required />
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-3 container-fluid">
                                                <button type="submit" class="btn btn-block account-btn mx-auto text-white">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>       
                            <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                                <div class="form-outline mb-4">
                                    <h3 class="text-center mb-3">Deletar conta</h3>
                                    <p class="text-center">Ficamos tristes com a sua decisão, mas entedemos :(</p>
                                    <hr>
                                    @include('/components/alert')
                                    <div class="row mt-3">
                                        <div class="col-md-3 mb-3 container-fluid">
                                            <button type="button" class="btn btn-block btn-danger mx-auto" data-toggle="modal" data-target="#modal_delete">Deletar conta</button>
                                        </div>

                                        <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog"   aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Deletar conta</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"><i class="fas fa-times text-danger"></i> </span>
                                                        </button>
                                                    </div>                                                   
                                                    <div class="text-center">
                                                        <form class="account-form" action="{{ route('delete_account') }}" method="POST">
                                                        @csrf
                                                            <span>Tem certeza que deseja excluir a sua conta?</span>
                                                            <p><i class="fas fa-exclamation-triangle text-danger"></i> Você perderá todas as suas notas, listas, agendas e projetos!</p>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
                                                            <button type="submit" class="btn btn-danger">Tenho certeza</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<script>
//Adiciona o nome da tab na url
$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
  $('.nav-tabs a').click(function (e) {
    setTimeout(function(){$('.alert').hide();}, 100);
    $(this).tab('show');
    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });
});
</script>