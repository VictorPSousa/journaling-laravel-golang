function checkThis(input){
    $(input).attr('checked', '');
}

function removeThis(item){
    $(item).parent().remove();
}

function appearButtons(card){
    $('#' + card + ' .card-buttons').css('display', 'block');
}

function editNote(note){
    let card = note.split('-');
    let id = card[1];
    let listTitle = $('#' + note + ' h3').html();

    if($('#' + note + ' .card-body-content').html()){
        listContent = $('#' + note + ' .card-body-content').html();
        listContent = "<div class=\"card-body-content\" contenteditable=\"true\">" + listContent + "</div>";
    }else{
        listContent = $('#' + note + ' .card-body-list').html();
        listContent = "<div class=\"card-body-list\">" + listContent + "</div>";
    }

    $.ajax({
        method: "POST",
        url: "http://127.0.0.1:8000/edit_note",
        data: {
            id: id,
            title: listTitle,
            description: listContent
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(data){
        location.reload();
    });
}

function deleteNote(note){
    let card = note.split('-');
    let id = card[1];

    $.ajax({
        method: "POST",
        url: "http://127.0.0.1:8000/delete_note",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(data){
        $('#' + note).remove();
    });
}

function sendData(prefix){
    let listTitle = $('#nome-' + prefix).val();
    let listContent = '';

    if(prefix == 'list'){
        listContent = $('#todo-list').html();
        listContent = "<div class=\"card-body-list\">" + listContent + "</div>";
    }else{
        listContent = $('#conteudo_nota').val();
        listContent = "<div class=\"card-body-content\" contenteditable=\"true\">" + listContent + "</div>";
    }

    $.ajax({
        method: "POST",
        url: "http://127.0.0.1:8000/create_note",
        data: {
            title: listTitle,
            description: listContent
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(data){
        location.reload();
    });
}

$(document).ready(function(){
    "use strict";

    var todo = function(){
        $('.todo-list .todo-item input').click(function(){
            if($(this).is(':checked')){
                $(this).parent().parent().parent().toggleClass('complete');
            }else{
                $(this).parent().parent().parent().toggleClass('complete');
            }
        });

        $('.todo-nav .all-task').click(function(){
            $('.todo-list').removeClass('only-active');
            $('.todo-list').removeClass('only-complete');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $('.todo-nav .active-task').click(function(){
            $('.todo-list').removeClass('only-complete');
            $('.todo-list').addClass('only-active');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $('.todo-nav .completed-task').click(function(){
            $('.todo-list').removeClass('only-active');
            $('.todo-list').addClass('only-complete');
            $('.todo-nav li.active').removeClass('active');
            $(this).addClass('active');
        });

        $('#uniform-all-complete input').click(function(){
            if($(this).is(':checked')){
                $('.todo-item .checker span:not(.checked) input').click();
            } else {
                $('.todo-item .checker span.checked input').click();
            }
        });
    };

    todo();

    $(".add-task").keypress(function (e){
        if((e.which == 13) && (!$(this).val().length == 0)){
            $('#todo-list').append('<div class="todo-item"><div class="checker"><span class=""><input class="itns" type="checkbox" onclick="checkThis(this)"></span></div> <span>' + $(this).val() + '</span><a href="javascript:" onclick="removeThis(this)" class="float-right remove-todo-item">&times;</a></div>');
            $(this).val('');
        }else if(e.which == 13){
            // Aviso para Inserir um item válido
            alert('Por favor, digite o item corretamente!');
        }
        $(document).on('.todo-list .todo-item.added input').click(function(){
            if($(this).is(':checked')){
                $(this).parent().parent().parent().toggleClass('complete');
            }else{
                $(this).parent().parent().parent().toggleClass('complete');
            }
        });
    });

    removeThis();

    checkThis();

    sendData();

    appearButtons();

    editNote();

    deleteNote();
});
