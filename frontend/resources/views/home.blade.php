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

                        @include('/components/cards')

                        <div class="col-12 mb-5">
                            <div class="card responsive-card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        <img src="{{asset('img/responsive-card.png')}}" class="img-fluid" />
                                    </div>
                                    <div class="col-md-6 responsive-text">
                                        <h2>Leve a Organização para qualquer lugar</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include('/components/footer')
        </div>
    </body>
</html>
