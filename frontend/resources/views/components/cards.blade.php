<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4">
    <div class="card home-card">
        <div class="card-img">
            <img src="{{asset('img/card-1.png')}}" class="img-fluid" />
        </div>
        <div class="card-bottom">
            <a href="@if(session('email'))
                        {{ url('user/schedule') }}
                    @else
                        {{ url('/schedule' ) }}
                    @endif" class="card-bottom-link"></a>
            <div class="row col-12 mt-3">
                <div class="col-7 col-md-6 col-sm-6 col-lg-10 col-xl-10">
                    <h3 class="mb-0 mt-2">Agenda</h3>
                </div>
                <div class="col-5 col-md-6 col-sm-6 col-lg-2 col-xl-2 text-right p-0 mb-3">
                    <a href="@if(session('email'))
                                {{ url('user/schedule') }}
                            @else
                                {{ url('/schedule' ) }}
                            @endif" class="arrow float-end"><i class="fas fa-chevron-circle-right fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4">
    <div class="card home-card">
        <div class="card-img">
            <img src="{{asset('img/card-2.png')}}" class="img-fluid" />
        </div>
        <div class="card-bottom">
            <a href="@if(session('email'))
                        {{ url('user/notes') }}
                    @else
                        {{ url('/lists' ) }}
                    @endif" class="card-bottom-link"></a>
            <div class="row col-12 mt-3">
                <div class="col-7 col-md-6 col-sm-6 col-lg-10 col-xl-10">
                    <h3 class="mb-0 mt-2">Listas</h3>
                </div>
                <div class="col-5 col-md-6 col-sm-6 col-lg-2 col-xl-2 text-right p-0 mb-3">
                    <a href="@if(session('email'))
                                {{ url('user/notes') }}
                            @else
                                {{ url('/lists' ) }}
                            @endif" class="arrow float-end"><i class="fas fa-chevron-circle-right fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4">
    <div class="card home-card">
        <div class="card-img">
            <img src="{{asset('img/card-3.png')}}" class="img-fluid" />
        </div>
        <div class="card-bottom">
            <a href="@if(session('email'))
                        {{ url('user/notes') }}
                    @else
                        {{ url('/notes' ) }}
                    @endif" class="card-bottom-link"></a>
            <div class="row col-12 mt-3">
                <div class="col-7 col-md-6 col-sm-6 col-lg-10 col-xl-10">
                    <h3 class="mb-0 mt-2">Notas</h3>
                </div>
                <div class="col-5 col-md-6 col-sm-6 col-lg-2 col-xl-2 text-right p-0 mb-3">
                    <a href="@if(session('email'))
                                {{ url('user/notes') }}
                            @else
                                {{ url('/notes' ) }}
                            @endif" class="arrow float-end"><i class="fas fa-chevron-circle-right fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4">
    <div class="card home-card">
        <div class="card-img">
            <img src="{{asset('img/card-4.png')}}" class="img-fluid" />
        </div>
        <div class="card-bottom">
            <a href="@if(session('email'))
                        {{ url('user/schedule') }}
                    @else
                        {{ url('/schedule' ) }}
                    @endif" class="card-bottom-link"></a>
            <div class="row col-12 mt-3">
                <div class="col-7 col-md-6 col-sm-6 col-lg-10 col-xl-10">
                    <h3 class="mb-0 mt-2">Controle Pessoal</h3>
                </div>
                <div class="col-5 col-md-6 col-sm-6 col-lg-2 col-xl-2 text-right p-0 mb-3">
                    <a href="@if(session('email'))
                                {{ url('user/schedule') }}
                            @else
                                {{ url('/schedule' ) }}
                            @endif" class="arrow float-end"><i class="fas fa-chevron-circle-right fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
