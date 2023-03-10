@extends('layouts.main-dashboard')

@section('content')
    <div class="sponsor-container">
        <div class="sponsor_list_title text-center mb-3">
            <h1 class="m-text-cursive m-3">Segli la promozione più adatta a te !</h1>
        </div>

        <div class="sponsors-card-container d-flex mt-2">
            @foreach ($sponsorships as $sponsor)
                <div class="sponsor-card m-2 d-flex flex-column">
                    <div class="sponsor-image-box d-flex flex-column align-items-center">
                        <img class="sponsor-image {{$sponsor->name}}" src="{{ Vite::asset('resources/img/IMG-20230220-WA0002_origin.png')}}" alt="">
                        <div class="sponsor-type {{$sponsor->name}}"><h4>{{$sponsor->name}}</h4></div>
                    </div>

                    <div class="sponsor-info mt-auto">
                        <div class="sponsor-dettagli text-center">
                            <p>Il pacchetto {{ $sponsor->name }} ti garantisce <span class="text-decoration-underline">{{ $sponsor->duration }} ore di sponsorizzazione.</span></p>
                        </div>

                        <div class="sponsor-price">
                            <a href="{{ route('admin.sponsors.show', $sponsor->slug) }}">
                                <button class="btn w-100" type="submit">Aquista per {{ $sponsor->price }} €</button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="m-text-cursive text-center mt-4 mb-0">Come funziona ?</h2>
        <div class="row align-items-center m-2 mt-0 sponsors-how">
            <div class="col-md-9">
                <h5>Sponsorizzando il tuo appartamento otterrai i seguenti benefici:</h5>

                <li>Apparirà in Homepage nella sezione “Appartamenti in Evidenza”</li>
                <li>Nelle pagine di ricerca, verrà sempre posizionato prima di un appartamento non sponsorizzato 
                che soddisfa le stesse caratteristiche di ricerca</li>
            </div>
            <div class="col-md-3 text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-cETReGrSEnsS4Sef4AY1eAzkVECciLGPjA&usqp=CAU" alt="">
            </div>
            
            <small class="mt-3 text-center">Terminato il periodo di sponsorizzazione, l’appartamento tornerà ad essere visualizzato normalmente, senza alcuna priorità.</small>
        </div>
    </div>
@endsection