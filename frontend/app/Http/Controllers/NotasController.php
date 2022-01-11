<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotasController extends Controller{
    private $url;
    private $client;

    public function __construct(){
        $this->url = "http://localhost:8082";
        $this->client = new \GuzzleHttp\Client();
    }

    // Cria nota
    public function create_note(Request $request){
        $mensagens = [
            'title.title' => 'Por favor insira um e-mail válido para realizar o cadastro.',
        ];

        $request->validate([
            'title' => 'required|max:32|min:2',
        ], $mensagens);

        $title = $request->title;
        $description = $request->description;

        try{
            $token = session('token');
            $email = session('email');
            $res = $this->client->request('POST', $this->url.'/note', [
                'json' => [
                    'title' => $title,
                    'description' => $description
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

    // Edita nota
    public function edit_note(Request $request){
        $id = (int)$request->id;
        $title = $request->title;
        $description = $request->description;
        $token = session('token');

        try{
            $res = $this->client->request('PUT', $this->url.'/note', [
                'json' => [
                    'id' => $id,
                    'title' => $title,
                    'description' => $description
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

    // Deleta a nota
    public function delete_note(Request $request){
        $id = (int)$request->id;
        $token = session('token');

        try{
            $res = $this->client->request('DELETE', $this->url.'/note', [
                'json' => [
                    'id' => $id
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

    // Retorna os dados de todas as notas
    public function get_notes(){
        try{
            $token = session('token');
            $res = $this->client->request('GET', $this->url.'/note', [
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            $notes = json_decode($res->getBody());
            return view('notes', ['notes' => $notes]);
        }catch(RequestException $e){
            return false;
        }
    }

    public function get_notes_in_dashboard(){
        try{
            $token = session('token');
            $res = $this->client->request('GET', $this->url.'/note', [
                'headers' => [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            $notes = json_decode($res->getBody());
            return view('dashboard', ['notes' => $notes]);;
        }catch(RequestException $e){
            return false;
        }
    }

}
