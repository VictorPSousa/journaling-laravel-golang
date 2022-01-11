<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ClienteController, NotasController};

Route::get('/', function(){
    return view('home');
});

Route::get('login', function(){
    return (!session('email') ? view('login') : redirect('user/dashboard'));
});

Route::get('recover', function(){
    return (!session('email') ? view('recover') : redirect('user/dashboard'));
});

Route::get('register', function(){
    return (!session('email') ? view('register/register') : redirect('user/dashboard'));
});

// permissionamento de acesso
Route::get('user/{page?}', [ClienteController::class, 'check_access']);

// Cadastra usuário
Route::post('/register', [ClienteController::class, 'create_user'])->name('register_user');

// Editar informações de usuário
Route::post('/edit_user', [ClienteController::class, 'edit_user'])->name('edit_user');

// Confirmar senha de usuário
Route::post('/confirm_pass', [ClienteController::class, 'confirm_pass'])->name('confirm_pass');

// Editar senha de usuário
Route::post('/edit_pass', [ClienteController::class, 'edit_pass'])->name('edit_pass');

// Deletar conta de usuário
Route::post('/delete_account', [ClienteController::class, 'delete_account'])->name('delete_account');

// Realiza o Login
Route::post('/login', [ClienteController::class, 'login'])->name('enter');

// Realiza o Logout
Route::get('/logout', [ClienteController::class, 'logout']);

// Recupera acesso do usuário
Route::post('/recover_user_access', [ClienteController::class, 'recover_user_access'])->name('recovery');

// Recupera acesso ao sistema
Route::post('/recover_user_access_save', [ClienteController::class, 'recover_user_access_save'])->name('recover_access');

// Continua com página para o processo de recuperação de acesso do usuário
Route::get('user/recovery', function(){
    return (!session('email') ? view('register/register') : redirect('user/dashboard'));
});

// Sobre projetos, agendas, notas e listas
Route::get('notes', function(){
    return view('about/notes-about');
});

Route::get('lists', function(){
    return view('about/lists-about');
});

Route::get('schedule', function(){
    return view('about/schedule-about');
});

Route::post('/get_schedule_by_month', [ClienteController::class, 'get_schedule_by_month'])->name('get_schedule_by_month');

Route::get('projects', function(){
    return view('about/projects-about');
});

// Cadastra nota
Route::post('/create_note', [NotasController::class, 'create_note'])->name('create_note');

// Deleta nota
Route::post('/delete_note', [NotasController::class, 'delete_note'])->name('delete_note');

// Edita nota
Route::post('/edit_note', [NotasController::class, 'edit_note'])->name('edit_note');

// Agenda

// Adicionar evento
Route::post('/add_event', [ClienteController::class, 'add_event'])->name('add_event');

// Editar evento
Route::post('/edit_event', [ClienteController::class, 'edit_event'])->name('edit_event');

// Deletar evento
Route::post('/delete_event', [ClienteController::class, 'delete_event'])->name('delete_event');