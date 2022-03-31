# Aplicativo para Journaling em Laravel (PHP) e GoLang

O objetivo deste app é possibilitar ao usuário fazer o controle das suas atividades pessoais, bem como anotações relativas a seus tópicos de interesse, já que este é um importante passo a fim de se atingir uma maior produtividade e organização pessoal.

Este aplicativo prevê a elaboração de uma plataforma que permita aos usuários o controle de tarefas a fazer em seu calendário pessoal, através de to-do lists, associe-as a projetos pessoais bem como permita-os fazer anotações relativas aos tópicos de seu interesse em uma espécie de diário.

Futuramente serão feitas atualizações para incrementar a funcionalidade da aplicação. Novas ferramentas serão aplicadas como o _docker-compose_, K8S, e Swapper para documentação da API. Também aplicaremos TDD nas novas funcionalidades de _DashBoard_, melhorias na página de Notas (com possibilidade de fixa-lás e dar um comportamento mais dinâmico), melhoria na parte de recuperação de conta e realizar o logout automático.

---

## Front-End

Posteriormente o front-end deste projeto poderá ser atualizado para um framework ou library JS mais moderno que otimize a navegação e a interface de uma forma mais intuitiva.

### Instalação -

#### 1º Passo:
Ter as seguintes ferramentas em sua máquina:
- PHP;
- Composer;
- Laravel;
- Git;
- Go;
- MySQL.

#### 2º Passo
Criar um diretório local e clonar o repositório:

> mkdir aplicativo <br/>
> cd aplicativo <br/>
> git clone https://github.com/VictorPSousa/journaling-laravel-golang.git .

#### 3º Passo
Copiar o arquivo .env.example e renomear para .env e colar novamente o arquivo .env.example

#### 4º Passo

> composer install <br/>
> php artisan key:generate <br/>
> php artisan serve <br/>

---

## Back-End

API de microserviços em GoLang (estudar mudança para o desenvolvimento de uma API REST em Laravel).

### Execução

#### **1º Passo**

Checar as configurações de banco de dados e de porta dos serviços.
Essa configuração de ambiente é localizada em:
```
    [nome-do-serviço]/cmd/config/environment.go
    [nome-do-serviço]/cmd/config/local.go
```

#### **2º Passo**

> cd notes/cmd <br/>
> go run . <br/>

> cd users/cmd <br/>
> go run . <br/>

> cd schedule/cmd <br/>
> go run . <br/>

---

## Colaboradores

[Débora Miyake](https://github.com/DeboraMiyake)

[Victor Sousa](https://github.com/VictorPSousa)

[Jhonny](https://github.com/Jhonnycpp)

[Estevão Luiz](https://github.com/estevaoldc)
