@include('/components/header')
@include('/components/navbar')

    <body class="dashboard">
        <div class="bg-dashboard"></div>
        <main>
            <div class="container">
                <h1 class="dashboard-titles">Meu espaço</h1>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card cards-dash">
                            <div class="row col-12 cards-dash-title">
                                <div class="col-4 col-md-4 col-sm-4 col-lg-7 col-xl-10">
                                    <h3 class="mb-0 mt-3">Notas e Listas</h3>
                                </div>
                                <div class="col-5 col-md-4 col-sm-4 col-lg-2 col-xl-2 text-right p-0 mb-3 mt-2">
                                    <a href="{{ url('user/notes') }}" class="arrow float-end"><i class="fas fa-chevron-circle-right fa-lg"></i></a>
                                </div>
                            </div>
                            <div class="row p-3">

                                @if(!empty($notes))
                                    @foreach ($notes as $card)
                                        @if($loop->iteration == 4)
                                            @break
                                        @endif
                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-4">
                                            <div class="card notes">
                                                <h3>{!! $card->title !!}</h3>
                                                {!! $card->description !!}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-4">
                                        <div class="card notes">
                                            Seu espaço de anotações está vazio...
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="dashboard-titles">O que você quer fazer primeiro?</h1>
                <div class="dashboard-container">
                    <div class="row">
                        @include('/components/cards')
                    </div>
                </div>
            </div>
        </main>
        @include('/components/footer')
        <script>
            $("input").prop("disabled", true);
            $(".card-body-content").prop("contenteditable", false);
        </script>
    </body>
</html>
