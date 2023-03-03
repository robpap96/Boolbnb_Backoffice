@extends('layouts.main-dashboard')

@section('content')
    @if (session('message'))
        <div class="alert alert-success m-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="sponsor-container">
        <div class="sponsor-card mb-3 d-flex">
            <div class="sponsor-image-box">
                <img class="sponsor-image {{$sponsor->name}}" src="{{ Vite::asset('resources/img/IMG-20230220-WA0002_origin.png')}}" alt="">
                <div class="sponsor-type {{$sponsor->name}}"><h4>{{$sponsor->name}}</h4></div>
            </div>

            <div class="sponsor-info d-flex justify-content-between w-100">
                <div class="sponsor-dettagli d-flex flex-column ">
                    <h3>Pacchetto {{ $sponsor->name }}</h3>
                    <p>Il pacchetto {{ $sponsor->name }} ti garantisce fino a {{ $sponsor->duration }} Lorem, ipsum dolor sit amet consectetur adipisicing elit. </p>
                    <small class="mt-auto">Durata promozione: {{ $sponsor->duration}} ore</small>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.sponsors.buy', $sponsor->name) }}">
            <select name="apartment_sponsored" id="" class="form-select">
                <option value="" selected hidden>Lista appartamenti</option>
                @if ( $apartments->isEmpty() )
                    <option value="no_apartments" disabled>Pare che tu non abbia ancora creato un appartamento. Creane subito uno!</option>
                @else 
                    @foreach ($apartments as $apartment)
                        @if ($apartment->is_visible) 
                            <option value="{{$apartment->id}}">{{ $apartment->title }} - {{ $apartment->full_address }}</option>
                        @else 
                            <option class="text-muted select_disabled" value="{{$apartment->id}}" disabled>{{ $apartment->title }} - {{ $apartment->full_address }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @error('apartment_sponsored')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="my-3 alert alert-warning">
                <small><strong>Nota bene:</strong> Gli appartamenti non visibili non potranno essere sponsorizzati.</small>
            </div>

            <div class="container">
                    <div class="col-12 mt-4">
                        <div class="card p-3">
                            <p class="mb-0 fw-bold h4">Seleziona metodo di pagamento</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card p-3">
                            <div class="card-body border p-0">
                                <p>
                                    <a class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-between"
                                        data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true"
                                        aria-controls="collapseExample">
                                        <span class="fw-bold">PayPal</span>
                                        <span class="fab fa-cc-paypal">
                                        </span>
                                    </a>
                                </p>
                                <div class="collapse p-3 pt-0" id="collapseExample">
                                    <div class="row">
                                        <div class="col-8">
                                            <p class="h4 mb-0">Summary</p>
                                            <p class="mb-0"><span class="fw-bold">Product:</span><span class="c-green">: {{ $apartment->title }}</span></p>
                                            <p class="mb-0"><span class="fw-bold">Prezzo:</span><span
                                                    class="c-green">: {{ $sponsor->price }} €</span></p>
                                            <small class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque
                                                nihil neque
                                                quisquam aut
                                                repellendus, dicta vero? Animi dicta cupiditate, facilis provident quibusdam ab
                                                quis,
                                                iste harum ipsum hic, nemo qui!</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border p-0">
                                <p>
                                    <a class="btn btn-primary p-2 w-100 h-100 d-flex align-items-center justify-content-between"
                                        data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true"
                                        aria-controls="collapseExample">
                                        <span class="fw-bold">Credit Card</span>
                                        <span class="">
                                            <span class="fab fa-cc-amex"></span>
                                            <span class="fab fa-cc-mastercard"></span>
                                            <span class="fab fa-cc-discover"></span>
                                        </span>
                                    </a>
                                </p>
                                <div class="collapse show p-3 pt-0" id="collapseExample">
                                    <div class="row">
                                        <div class="col-lg-5 mb-lg-0 mb-3">
                                            <p class="h4 mb-0">Summary</p>
                                            <p class="mb-0"><span class="fw-bold">Product:</span><span class="c-green">: {{ $apartment->title }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Price:</span>
                                                <span class="c-green">: {{ $sponsor->price }} €</span>
                                            </p>
                                            <small class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque
                                                nihil neque
                                                quisquam aut
                                                repellendus, dicta vero? Animi dicta cupiditate, facilis provident quibusdam ab
                                                quis,
                                                iste harum ipsum hic, nemo qui!</small>
                                        </div>
                                        <div class="col-lg-7">
                                            <form action="" class="form">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form__div">
                                                            <input type="text" class="form-control" placeholder=" ">
                                                            <label for="" class="form__label">Card Number</label>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="form__div">
                                                            <input type="text" class="form-control" placeholder=" ">
                                                            <label for="" class="form__label">MM / yy</label>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-6">
                                                        <div class="form__div">
                                                            <input type="password" class="form-control" placeholder=" ">
                                                            <label for="" class="form__label">cvv code</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form__div">
                                                            <input type="text" class="form-control" placeholder=" ">
                                                            <label for="" class="form__label">name on the card</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="sponsor-price">
                <button type="submit" class="btn btn-success w-25">Aquista {{ $sponsor->price }} €</button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">Indietro</a>
            </div>
        </form>
    </div>
@endsection