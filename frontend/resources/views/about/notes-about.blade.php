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
                        <h1 class="w-100">Notas</h1>
                        <img src="{{ asset('img/exemplo-notas-listas.png') }}" class="img-about mt-3 mb-5" alt="Tela de notas do site, mostrando uma anotação da aula de biologia do usuário e uma lista de itens de mercado." />
                        <p class="paragraph">O serviço de Notas do aplicativo é uma funcionalidade extremamente completa, dinâmica e muito intuitiva de se usar.</p>
                        <p class="paragraph">Guarde rapidamente todas as tuas ideias e se lembre das mesmas a qualquer momento e em qualquer lugar do mundo, seja no computador, TV, tablet ou celular. Organize documentos e gerencie-os, também os ache com facilidade na interface leve e objetiva. Com a funcionalidade de Notas, você pode salvar facilmente uma ideia ou uma obrigação para relembrar e compartilhar com quem quiser.</p>
                        <p class="paragraph">As Notas sempre estarão aos seu alcance, o aplicativo é totalmente compatível com seu smartphone, tablet e computador. Tudo o que você é ter Internet em todos os seus dispositivos. Dessa forma, o que é importante sempre estará você. </p>
                        @include('/components/about-page-btn')
                    </div>
                </div>
            </main>
            @include('/components/footer')
        </div>
    </body>
</html>
