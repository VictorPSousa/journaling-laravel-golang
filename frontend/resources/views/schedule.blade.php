@include('/components/header')
@include('/components/navbar') 

<body class="schedule">
    <main class="schedule">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-12 mt-5">
                <!-- botao abre modal de adicionar eventos -->
                <div class="menu-calendar">
                    <button type="button" id="btn_add_event" class="btn float-right " data-toggle="modal" data-target="#modalNewEvent">
                        <span class="btn_text"> Adicionar evento </span>
                        <span class="button-plus ml-2"><i class="fas fa-plus"></i></span>
                    </button>
                </div>
                <!-- calendario -->
                <div class="calendario">
                    <div id="myCalendar" class="vanilla-calendar mb-5"></div>
                </div>
            </div>
          
            <!-- modal novo evento -->
            <div class="modal fade mt-5" id="modalNewEvent" tabindex="-1" role="dialog" aria-labelledby="modalNewEvent" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h5 class="modal-title">Adicionar novo evento</h5>
                            <button type="button" id="close_add_modal" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="success-add-event"></div>
                                <div class="col-md-12" id="error-add-event"></div>

                                <div class="col-md-12">
                                    <label class="form-label" for="nome">Nome</label>
                                    <input type="text" id="nome" class="form-control mb-4" placeholder="Nome do evento">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="desc">Descrição</label>
                                    <input type="text" id="desc"  class="form-control mb-4" placeholder="Descrição">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="dt_inicial">Data Inicial</label>
                                    <input type="date" id="dt_inicial" class="form-control mb-4">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="dt_final">Data Final</label>
                                    <input type="date" id="dt_final" class="form-control mb-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 container-fluid">
                            <button onclick="add_event()"  class="btn btn-block bg-blue mx-auto">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal editar evento -->
            <div class="modal fade mt-5" id="modalEditEvent" tabindex="-1" role="dialog" aria-labelledby="modalNewEvent" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h5 class="modal-title">Editar evento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="success-edit-event"></div>
                                <div class="col-md-12" id="error-edit-event"></div>

                                <div class="col-md-12">
                                    <label class="form-label" for="nome">Nome</label>
                                    <input type="text" id="nome_edit" class="form-control mb-4" placeholder="Nome do evento">
                                </div>
                                <input type="hidden" name="id" id="id_event">
                                <div class="col-md-12">
                                    <label class="form-label" for="desc">Descrição</label>
                                    <input type="text" id="desc_edit"  class="form-control mb-4" placeholder="Descrição">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="dt_inicial">Data Inicial</label>
                                    <input type="date" id="dt_inicial_edit" class="form-control mb-4">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="dt_final">Data Final</label>
                                    <input type="date" id="dt_final_edit" class="form-control mb-4">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 container-fluid">
                            <button onclick="edit_event()" type="submit" id="btn-submit" class="btn btn-block bg-blue mx-auto">Atualizar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal deletar evento -->
            <div class="modal fade mt-5" id="modalDeleteEvent" tabindex="-1" role="dialog" aria-labelledby="modalNewEvent" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            <h5 class="modal-title">Deletar evento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="text-center">
                                <span class="d-block mb-3">Tem certeza que deseja excluir esse evento?</span>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_close">Não</button>
                                <button id="btn_delete" type="button" class="btn btn-danger" data-id="" onclick="deleteEvent(this)">Excluir evento</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer text-center mt-5">
        <div class="text-center p-4">© 2021 Orgen - Todos os direitos reservados.</div>
    </footer>

    <script>
        // Inicializa o calendário
        let calendar = new VanillaCalendar({
            selector: "#myCalendar",
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            shortWeekday: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
        });

        // Chama a função para buscar eventos do mês atual ao carregar o calendário
        let year_month = new Date().getFullYear()+'-'+(new Date().getMonth()+1);
        searchEvent(year_month);

        //Faz a requisição passando o ano e mês para consultar os eventos correspondentes ao intervalo
        function searchEvent(year_month){
            $.ajax({
                method: "POST",
                url: "http://127.0.0.1:8000/get_schedule_by_month",
                data: { 
                    year_month: year_month
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data){
                $.each(data, function(i) {
                    //Tratando formato da data
                    data[i].starts_at = new Date(data[i].starts_at.split('T')[0].replaceAll('-','/'));
                    data[i].ends_at = new Date(data[i].ends_at.split('T')[0].replaceAll('-','/'));
                });
                
                let event = data;
                //Tratando as datas correspondentes aos eventos
                let dates = () => {
                    let days = [];
                    $.each(event, function(i) {
                        //Laço que percorre a partir da data inicial até a data final de cada evento 
                        for (let day = event[i].starts_at; day <= event[i].ends_at; day.setDate(day.getDate() + 1)) {
                            let date = `${String(day.getFullYear())}-${String(day.getMonth() + 1).padStart(2, 0)}-${String(day.getDate()).padStart(2, 0)}`;
                            //Trata cada data para armazenar mais de um evento
                            days.push({
                                date: date,
                                index: i
                            });

                            const daysIndex = days.reduce((objs, {
                                date,
                                index,
                                desc
                            }) => {
                                if (!objs[date]) {
                                    objs[date] = [];
                                }
                                objs[date].push(index);
                                return objs;

                            }, {});

                            result = Object.keys(daysIndex).map(date => {
                                return {
                                    date,
                                    index: daysIndex[date],
                                };
                            });
                        }
                    });
                    return result
                }
               
                //Atualiza o calendário para preencher as datas com os eventos correspondentes
                calendar.set({
                    availableDates: dates(),
                    datesFilter: true
                });
                
                calendar.reset();
              
                //Classe dos botões de anterior e próximo
                $('.vanilla-calendar-btn').click(function() {
                    //Chamada recursiva para a função buscar todos os eventos associados ao mês selecionado
                    searchEvent($(this).attr('data-current-date')); 
                    //Chama a função que exibe os eventos
                    // showEvents();    
                });

                let showEvents = () => {
                    //Percorre todas as datas que possuem eventos
                    $('.vanilla-calendar-date--active').each(function(i) {
                        $(this).attr('data-id', i);
                   
                        var proj = $(this).data('index');
                      
                        if (proj.indexOf(",") != -1) {
                            var proj = $(this).data('index').split(',');
                        }
                       
                        $.each(proj, function(index) {
                            let j = proj[index];

                            //Limitando caracteres no nome do projeto
                            if(event){
                                let projeto = event[j].title;

                                if (projeto.length > 16) {
                                    projeto = projeto.substring(0, 16) + '...';
                                }

                                $('.vanilla-calendar-date--active[data-id=' + i + ']').append("<p class='projetos'>" + projeto + "</p>" +
                                    "<span class='tt'>" +
                                    "<span class='close-tt'><i class='fas fa-times'></i></span>" +
                                    "<span class='text-tt-icons' data-id='"+event[j].id+"' data-index='"+j+"' onclick='getEventBy(this)' data-toggle='modal' data-target='#modalEditEvent'><i class='far fa-edit'></i></span>" +
                                    "<span class='text-tt-icons mr-2' data-id='"+event[j].id+"' onclick='deleteEvent(this)' data-toggle='modal' data-target='#modalDeleteEvent'><i class='far fa-trash-alt'></i></span>" +
                                    "<span class='text-tt-title'>" + event[j].title + "</span>" +
                                    "<span>" + event[j].description + "</span>" +
                                    "</span>");
                            }
                        });
                      
                        $(".vanilla-calendar-date--active .projetos").each(function(i, val) {
                            //Fixa a descrição do evento 
                            $(this).click(function(){
                                $(this).next().addClass('fixed-desc');

                                //Fecha a descrição dos outros eventos
                                $('.tt').not($(this).next()).removeClass('fixed-desc') ;
                            });

                            //Fecha a descrição do evento correspondente ao clicar no icone de fechar
                            $('.close-tt').click(function(){
                                $(this).parent().removeClass('fixed-desc');
                            });
                           
                        });     
                    });
                }
                showEvents();          
            });
        }   

        //Limpando os alerts do modal
        $('#btn_add_event').click(function(){
            $('#success-add-event').empty();
            $('#error-add-event').empty();

            $('#nome').val('');
            $('#desc').val('');
            $('#dt_inicial').val('');
            $('#dt_final').val('');
        });

        function getEventBy(event){
            $('#success-edit-event').empty();
            $('#error-edit-event').empty();

            let index = event.getAttribute('data-index');
            let year_month = $('.vanilla-calendar-btn').attr('data-current-date');
         
            $.ajax({
                method: "POST",
                url: "http://127.0.0.1:8000/get_schedule_by_month",
                data: { 
                    year_month: year_month
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data){
                //Popula o modal de edição de eventos
                let starts_at = data[index].starts_at.split('T')[0];
                let ends_at = data[index].ends_at.split('T')[0];

                $('#id_event').val(data[index].id);
                $('#nome_edit').val(data[index].title);
                $('#desc_edit').val(data[index].description);
                $('#dt_inicial_edit').val(starts_at);
                $('#dt_final_edit').val(ends_at);
            });
        }  

        function add_event(event){
            $('#success-add-event').empty();
            $('#error-add-event').empty();

            let nome = $('#nome').val();
            let desc = $('#desc').val();
            let dt_inicial = $('#dt_inicial').val();
            let dt_final = $('#dt_final').val();
            let prefix = $('.vanilla-calendar-btn').attr('data-current-date');
            if(!nome || nome == ' '){
                $('#error-add-event').append('<div class="alert alert-danger" role="alert">Insira o nome do evento para cadastrar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }else if(dt_inicial > dt_final ){
                $('#error-add-event').append('<div class="alert alert-danger" role="alert">A data inicial deve ser inferior a data final!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }else{
                $.ajax({
                    method: "POST",
                    url: "http://127.0.0.1:8000/add_event",
                    data: { 
                        nome: nome,
                        desc: desc,
                        dt_inicial: dt_inicial,
                        dt_final: dt_final
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(data){
                    if(data){
                        $('#success-add-event').append('<div class="alert alert-success" role="alert">Evento inserido com sucesso!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#error-add-event').append('<div class="alert alert-danger" role="alert">Falha ao inserir! Tente novamente!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    //Atualiza o calendário após inserir
                    searchEvent(prefix);
                });
            }
        }

        function edit_event(event){
            $('#success-edit-event').empty();
            $('#error-edit-event').empty();

            let id = $('#id_event').val();
            let nome = $('#nome_edit').val();
            let desc = $('#desc_edit').val();
            let dt_inicial = $('#dt_inicial_edit').val();
            let dt_final = $('#dt_final_edit').val();
            let prefix = $('.vanilla-calendar-btn').attr('data-current-date');

            if(!nome || nome == ' '){
                $('#error-edit-event').append('<div class="alert alert-danger" role="alert">Ops... Não é possível salvar um evento sem nome!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }else if(dt_inicial > dt_final ){
                $('#error-edit-event').append('<div class="alert alert-danger" role="alert">A data inicial deve ser inferior a data final!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }else{
                $.ajax({
                    method: "POST",
                    url: "http://127.0.0.1:8000/edit_event",
                    data: { 
                        id: id,
                        nome: nome,
                        desc: desc,
                        dt_inicial: dt_inicial,
                        dt_final: dt_final
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(data){
                    if(data){
                        $('#success-edit-event').append('<div class="alert alert-success" role="alert">Evento atualizado com sucesso!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#error-edit-event').append('<div class="alert alert-danger" role="alert">Falha ao inserir! Tente novamente!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    //Atualiza o calendário após inserir
                    searchEvent(prefix);
                });
            }
        }

        //Função para deletar evento
        function deleteEvent(event){
            let id = event.getAttribute('data-id');
            let prefix = $('.vanilla-calendar-btn').attr('data-current-date');
            
            if(event.getAttribute('data-toggle') == 'modal'){
                $('#btn_delete').attr('data-id', id);
            }else{
                $.ajax({
                    method: "POST",
                    url: "http://127.0.0.1:8000/delete_event",
                    data: { 
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(data){
                    //Atualiza o calendário após deletar
                    searchEvent(prefix);
                    $('#btn_close').trigger('click');
                });
            }
        }
    </script>
</body>
</html>