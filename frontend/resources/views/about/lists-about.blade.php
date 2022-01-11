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
                        <h1 class="w-100">Listas</h1>
                        <img src="{{ asset('img/exemplo-notas-listas.png') }}" class="img-about mt-3 mb-5" alt="Tela de notas do site, mostrando uma anotação da aula de biologia do usuário e uma lista de itens de mercado." />
                        <p class="paragraph">As Listas do aplicativo possuem um comportamento muito semelhante as Notas, tanto é que ambas foram colocadas no mesmo local para facilitar o acesso e deixar o aplicativo cada vez mais completo para você!</p>
                        <p class="paragraph">Liste e lembre-se das suas ideias e a fazeres em qualquer instante e lugar. Organize pensamentos e a sua rotina diária facilmente com segurança e despreocupação. Com o serviço de Listas, você pode com muita facilidade compartilhar o seu planejamento apenas com que você deseja.</p>
                        <p class="paragraph">As Listas sempre estão disponíveis para você, o aplicativo é compatível com seu celular, TV, notebook, tablet e PC. Você só precisa ter apenas uma conexão com a Internet nos teus dispositivos. Assim o importante sempre ficará com você. </p>
                        @include('/components/about-page-btn')
                    </div>
                </div>
            </main>
            @include('/components/footer')
        </div>
    </body>
</html>
