@include('/components/header')
@include('/components/navbar')

        <main class="container-notes my-4">
            <section class="row">
                <article class="col-md-12">
                    <div id="postits">

                        @if(!empty($notes))
                            @foreach ($notes as $card)
                                <div class="card" id="card-{!! $card->id !!}" onclick="appearButtons('card-{!! $card->id !!}')">
                                    <h3 contenteditable="true">{!! $card->title !!}</h3>
                                    {!! $card->description !!}
                                    <div class="card-buttons">
                                        <button class="btn btn-danger" onclick="deleteNote('card-{!! $card->id !!}')">Excluir</button>
                                        <button class="btn btn-primary" onclick="editNote('card-{!! $card->id !!}')">Salvar</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </article>
            </section>
            <button class="btn-new-note" type="button" data-toggle="modal" data-target="#exampleModal">Nova Nota <span class="circle-plus">+</span></button>
        </main>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Criar nova lista ou nota</h5>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs mdl justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="note-tab" data-toggle="tab" href="#note" role="tab" aria-controls="note" aria-selected="true">Nota</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">Lista</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabLists">
                            <div class="tab-pane fade show active" id="note" role="tabpanel" aria-labelledby="note-tab">
                                <div class="row">
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="nome-note">Nome da Nota</label>
                                        <input type="text" class="form-control" name="nome-note" id="nome-note" required/>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="conteudo_nota">Conteúdo</label>
                                        <textarea class="form-control" name="conteudo_nota" id="conteudo_nota"></textarea>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="button" id="save-note" onclick="sendData('note')" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                                <div class="row">
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="nome-list">Nome da Lista</label>
                                        <input type="text" class="form-control" name="nome-list" id="nome-list" required/>
                                    </div>
                                </div>
                                <div class="row mt-3 bt-1">
                                    <div class="col-md-12 mb-3">

                                        <form action="javascript:void(0);">
                                            <input type="text" class="form-control add-task" placeholder="Novo item...">
                                        </form>
                                        <div class="todo-list" id="todo-list"></div>

                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="button" id="save-list" onclick="sendData('list')" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-close-modal" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ asset('js/notes.js') }}" async></script>
    </body>
</html>
