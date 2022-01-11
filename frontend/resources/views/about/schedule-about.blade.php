@include('/components/header')
@include('/components/navbar')
        <div class="wrapper">
            <header class="banner">
                <div class="container">
                    <div class="page-title">Orgen</div>
                    <p class="page-subtitle">Organize sua rotina e seja mais produtivo</p>
                </div>
            </header>
            <main>
                <div class="container home-container">
                    <div class="row">
                        <h1 class="w-100">Agenda</h1>
                        <img src="{{ asset('img/exemplo-agenda.png') }}" class="img-about mt-3 mb-5" alt="Calendário com eventos marcados em dias específicos." />
                        <p class="paragraph">Aproveite o máximo do seu dia com a nossa Agenda, este serviço que ajuda você a perder menos tempo controlando a sua rotina e mais tempo curtindo a vida.</p>
                        <p class="paragraph">A Agenda tem um visual acessível que proporciona uma navegação agradável e que faz com que seja mais fácil ver o que está pela sua frente, com dias, semanas, meses e eventos todos bem estruturados e claramente definidos.</p>
                        <p class="paragraph">Com a Agenda fica super fácil de planejar com antecedência vários eventos utilizando a visualização mensal. Veja rapidamente qualquer dia e saiba se você estará livre ou não.</p>
                        @include('/components/about-page-btn')
                    </div>
                </div>
            </main>
            @include('/components/footer')
        </div>
    </body>
</html>
