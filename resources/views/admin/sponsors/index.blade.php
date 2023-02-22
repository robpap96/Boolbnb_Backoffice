@extends('layouts.main-dashboard')

@section('content')
    <div class="sponsor-container">
        <div class="sponsor_list_title text-center mb-3">
            <h1>Segli la promozione più adatta a te!</h1>
        </div>
            @foreach ($sponsorships as $sponsor)
                <div class="sponsor-card m-2 d-flex">
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

                        <div class="sponsor-price d-flex flex-column justify-content-end">
                            <a href="{{ route('admin.sponsors.show', $sponsor) }}">
                                <button class="btn " type="submit">Aquista {{ $sponsor->price }} €</button>
                            </a>
                        </div>
                    </div>
                </div>
        @endforeach
@endsection