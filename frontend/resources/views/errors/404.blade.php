@include('/components/header')

<body class="error-404">
    <main class="container">
        <section class="row">
            <div class="col-12 mt-5 pt-5 text-white">
                <h1 class="display-4 text-center mt-5 pt-5">Orgen</h1>
                <h1 class="display-1 text-center">404</h1>
                <h1 class="display-3 text-center mt-5">Página não encontrada</h1>
                <h3 class="text-center mt-3">Nós pedimos desculpa, mas a página que você está tentando acessar não existe.</h3>
                <div class="row mt-3 mt-5">
                    <div class="col-6 col-md-6 mb-3">
                        <a class="btn-error" href="{{ url('/') }}"><button type="button" class="btn float-right">Home</button></a>
                    </div>
                    <div class="col-6 col-md-6 mb-3">
                        <a class="btn-error" href="{{ url('/login') }}"><button type="button" class="btn float-left">Login</button></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
