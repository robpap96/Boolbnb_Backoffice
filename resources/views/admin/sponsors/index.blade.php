@extends('layouts.main-dashboard')

@section('content')
    <div class="sponsor-container">
        <div class="sponsor_list_title text-center mb-3">
            <h1 class="m-text-cursive">Segli la promozione più adatta a te!</h1>
        </div>

        <div class="sponsors-card-container d-flex">
            @foreach ($sponsorships as $sponsor)
                <div class="sponsor-card m-2">
                    <div class="sponsor-image-box d-flex flex-column align-items-center">
                        <img class="sponsor-image {{$sponsor->name}}" src="{{ Vite::asset('resources/img/IMG-20230220-WA0002_origin.png')}}" alt="">
                        <div class="sponsor-type {{$sponsor->name}}"><h4>{{$sponsor->name}}</h4></div>
                    </div>

                    <div class="sponsor-info">
                        <div class="sponsor-dettagli text-center">
                            <p>Il pacchetto {{ $sponsor->name }} ti garantisce <span class="text-decoration-underline">{{ $sponsor->duration }} ore di sponsorizzazione.</span></p>
                        </div>

                        <div class="sponsor-price">
                            <a href="{{ route('admin.sponsors.show', $sponsor->slug) }}">
                                <button class="btn w-100" type="submit">Aquista {{ $sponsor->price }} €</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="">
            <h3>Come funziona ?</h3>
            Un appartamento sponsorizzato ha le seguenti particolarità:
            <ul>
                <li>Appare in Homepage nella sezione “Appartamenti in Evidenza”</li>
                <li>
                    Nella pagina di ricerca, viene posizionato sempre prima di un appartamento non
                    sponsorizzato che soddisfa le stesse caratteristiche di ricerca
                </li>
            </ul>
            Terminato il periodo di sponsorizzazione, l’appartamento tornerà ad essere
            visualizzato normalmente, senza alcuna particolarità.
        </p>
    </div>
@endsection