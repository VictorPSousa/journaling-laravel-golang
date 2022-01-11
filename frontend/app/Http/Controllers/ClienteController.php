<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class ClienteController extends Controller{
    private $url;
    private $pages;
    private $client;

    public function __construct(){
        $this->url = "http://localhost:8080";
        $this->pages = ['dashboard', 'notes', 'schedule', 'myaccount'];
        $this->client = new \GuzzleHttp\Client();
    }

    // Cria um usuário
    public function create_user(Request $request){
        $mensagens = [
            'email.email' => 'Por favor insira um e-mail válido para realizar o cadastro.',
            'senha.same' => ' As senhas não correspondem, por favor tente novamente!',
        ];

        $request->validate([
            'nome' => 'required|max:32|min:2',
            'sobrenome' => 'required|max:32|min:2',
            'email' => 'required|min:6|max:64|email:rfc,dns',
            'senha' => 'required|min:8|max:24|required_with:rsenha|same:rsenha',
            'rsenha' => 'required|min:8|max:24'
        ], $mensagens);

        $nome_completo = $request->nome.' '.$request->sobrenome;
        $email = $request->email;
        $senha = hash('sha512', $request->senha);
        $rsenha = hash('sha512', $request->rsenha);

        try{
            $res = $this->client->request('POST', $this->url.'/user', [
                'json' => [
                    'name' => $nome_completo,
                    'email' => $email,
                    'password' => $senha,
                    'confirm_password' => $rsenha
                ]
            ]);
            $request->session()->flash('alert-success', 'Cadastro realizado com sucesso! Faça login');
            return redirect('/login');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
            return redirect('/register');
        }
    }

    // Realiza login
    public function login(Request $request){
        $mensagens = [
            'email.email' => 'Usuário ou senha incorretos.'
        ];

        $request->validate([
            'email' => 'required|max:64|min:6|email:rfc,dns',
            'pass' => 'required|min:8|max:24',
        ], $mensagens );

        $email = $request->email;
        $senha = hash('sha512', $request->pass);

        try{
            $res = $this->client->request('POST', $this->url.'/login', [
                'json' => [
                    'email' => $email,
                    'password' => $senha
                ]
            ]);

            if($res->getStatusCode() == 200){
                // Valida a session
                $tk = json_decode($res->getBody());
                $user = $this->user_data($tk->token);
                $usuario = explode(" ", $user->name);

                $request->session()->put('nome', $usuario[0]);
                $request->session()->put('sobrenome', $usuario[1]);
                $request->session()->put('email', $user->email);
                $request->session()->put('token', $tk->token);

                return redirect('/user/dashboard');
            }
        }catch(RequestException $e){
            return redirect('/login')->withErrors($mensagens)->withInput($request->all());
        }
    }

    // Realiza o logout e limpa a sessão
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }

    // Retorna dados do usuário
    public function user_data($token){
        try{
            $response = $this->client->request('GET', $this->url.'/user', [
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            return json_decode($response->getBody());
        }catch(RequestException $e){
            // Token inválido
            return redirect('/login');
        }
    }

    // Checa a permissão e provê acesso para determinadas páginas
    public function check_access($page = ''){
        if(session('token') && $this->user_data(session('token'))){
            if($page == 'notes'){
                return app('App\Http\Controllers\NotasController')->get_notes();
            }else if($page == 'dashboard'){
                return app('App\Http\Controllers\NotasController')->get_notes_in_dashboard();
            }else{
                return (in_array($page, $this->pages) ? view($page) : redirect('user/dashboard'));
            }
        }else{
            return ($page == 'recovery') ? view($page) : redirect('/');
        }
    }

    // Funções para editar informações do usuário
    public function edit_user(Request $request){
        $nome_completo = $request->nome.' '.$request->sobrenome;
        try{
            $token = session('token');
            $res = $this->client->request('PUT', $this->url.'/user', [
                'json' => [
                    'name' => $nome_completo
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            //Atualizando a sessão
            $request->session()->put('nome',$request->nome);
            $request->session()->put('sobrenome', $request->sobrenome);

            $request->session()->flash('alert-success', 'Informações alteradas com sucesso!');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
        }
        return redirect('/user/myaccount#name');
    }

    // Recupera acesso do usuário ao sistema
    public function recover_user_access(Request $request){
        try{
            $email = $request->recover_email;
            $res = $this->client->request('POST', $this->url.'/user/recovery', [
                'json' => [
                    'email' => $email
                ]
            ]);
            $request->session()->flash('alert-success', 'Sua solicitação foi atendida com sucesso! Em instantes você receberá um email para efetuar a troca de senha.');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
        }
        return redirect('/login');
    }

    // Continua com recuperação do acesso do usuário ao sistema
    public function recover_user_access_save(Request $request){
        $mensagens = [
            'recover_email.email' => 'Por favor insira um e-mail válido para realizar o cadastro.',
            'recover_pass.same' => ' As senhas não correspondem, por favor tente novamente!',
        ];

        $request->validate([
            'recover_email' => 'required|min:6|max:64|email:rfc,dns',
            'recover_pass' => 'required|min:8|max:24|required_with:recover_pass_confirm|same:recover_pass_confirm',
            'recover_pass_confirm' => 'required|min:8|max:24'
        ], $mensagens);

        $email = $request->recover_email;
        $pass = hash('sha512', $request->recover_pass);
        $pass_confirm = hash('sha512', $request->recover_pass_confirm);
        if($pass == $pass_confirm){
            try{
                $res = $this->client->request('POST', $this->url.'/user/recoverybyemailandpassword', [
                    'json' => [
                        'email' => $email,
                        'Password' => $pass,
                        'ConfirmPassword' => $pass_confirm
                    ]
                ]);
                $request->session()->flash('alert-success', 'Senha alterada com sucesso!');
            }catch(RequestException $e){
                $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
            }
        }else{
            $request->session()->flash('alert-danger', 'Ops... Senhas incompatíveis.');
        }
        return redirect('/login');
    }

    // Testa a confirmação de senha do usuário
    public function confirm_pass(Request $request){
       $senha = hash('sha512', $request->old_pass);
        try{
            $res = $this->client->request('POST', $this->url.'/login', [
                'json' => [
                    'email' => session('email'),
                    'password' => $senha
                ]
            ]);
            $request->session()->flash('next-step', '');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Senha atual incorreta, por favor tente novamente!');
        }
        return redirect('/user/myaccount#senha');
    }

    // Edita senha do usuário
    public function edit_pass(Request $request){
        $request->session()->flash('next-step', '');

        $mensagens = [
            'required' => 'Por favor, preencha os dois campos com a sua nova senha.',
            'senha.min' => 'A sua nova senha deve conter no mínimo 8 caracteres.',
            'senha.max' => 'A sua nova senha deve conter no máximo 24 caracteres.',
            'senha.same' => 'Os dois campos devem ser iguais, tente novamente!'
        ];

        $request->validate([
            'senha' => 'required|min:8|max:24|required_with:rsenha|same:rsenha'
        ], $mensagens);

        $senha = hash('sha512', $request->senha);
        try{
            $token = session('token');
            $res = $this->client->request('PUT', $this->url.'/user', [
                'json' => [
                    'password' => $senha
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            $request->session()->flash('alert-success', 'Senha alterada com sucesso!');
            $request->session()->forget('next-step');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
        }
        return redirect('/user/myaccount#senha');
    }

    // Deleta conta do usuário
    public function delete_account(Request $request){
        try{
            $token = session('token');
            $res = $this->client->request('DELETE', $this->url.'/user', [
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            $request->session()->flush();
            return redirect('/');
        }catch(RequestException $e){
            $request->session()->flash('alert-danger', 'Ops... Ocorreu um erro, por favor tente novamente.');
            return redirect('/user/myaccount#delete');
        }
    }

    // Funções relacionadas aos eventos
    public function get_schedule_by_month(Request $request){
        $token = session('token');
        $year_month = $request->year_month;
        $ends_at = gmdate('Y-m-d\TH:i:s\Z', strtotime("1 month", strtotime($year_month.'-15')));
        try{
            $res = $this->client->request('POST', 'http://localhost:8081/schedules/search/alt', [
                'json' => [
                    'starts_at' => $year_month.'-01T00:00:00Z',
                    'ends_at' => $ends_at
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);               
            $schedule = json_decode($res->getBody(), true);
            return $schedule['events'];
        }catch(RequestException $e){
            return false;
        }
    }

    public function add_event(Request $request){        
        $nome = $request->nome;
        $desc = $request->desc;
        $dt_inicial = gmdate('Y-m-d\TH:i:s\Z', strtotime("1 day", strtotime($request->dt_inicial)));
        $dt_final = gmdate('Y-m-d\TH:i:s\Z', strtotime("1 day", strtotime($request->dt_final)));
        $token = session('token');

        try{
            $res = $this->client->request('POST', 'http://localhost:8081/schedules', [
                'json' => [
                    'title' => $nome,
                    'description' => $desc,
                    'starts_at' => $dt_inicial,
                    'ends_at' => $dt_final
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);          
            return true;
        }catch(RequestException $e){
            return false;
        }        
    }

    public function edit_event(Request $request){
        $id = $request->id;
        $nome = $request->nome;
        $desc = $request->desc;
        $dt_inicial = gmdate('Y-m-d\TH:i:s\Z', strtotime("1 day", strtotime($request->dt_inicial)));
        $dt_final = gmdate('Y-m-d\TH:i:s\Z', strtotime("1 day", strtotime($request->dt_final)));
        $token = session('token');

        try{
            $res = $this->client->request('PUT', 'http://localhost:8081/schedules', [
                'json' => [
                    'id' => $id,
                    'title' => $nome,
                    'description' => $desc,
                    'starts_at' => $dt_inicial,
                    'ends_at' => $dt_final
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);          
            return true;
        }catch(RequestException $e){
            return false;
        }        
    }

    public function delete_event(Request $request){
        $id = $request->id;
        $token = session('token');

        try{
            $res = $this->client->request('DELETE', 'http://localhost:8081/schedules', [
                'json' => [
                    'id' => $id,
                ],
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);          
            return true;
        }catch(RequestException $e){
            return false;
        }   
    }

}
