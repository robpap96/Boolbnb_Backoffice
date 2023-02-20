@extends('layouts.main-dashboard')

{{-- @section('page-title')
    |   
@endsection --}}

@section('content')
    <div id="admin-apartments-show">
        <div class="container">
            {{-- card singolo appartamento --}}
            <div class="container">
                <div class="card-title">
                    <h3>{{ $apartment->title }}</h3>
                    <h6>{{ $apartment->price }} <i class="fa-solid fa-euro-sign"></i> /notte</h6>
                    <h6><i class="fa-solid fa-location-dot"></i>{{ $apartment->full_address }}</h6>
                </div>
                <div class="card-body">
                    <img src="{{ $apartment->image }}" alt="">
                </div>
                <div class="card-text">
                        <ul class="d-flex list-unstyled">
                            <li class="me-3">{{ $apartment->rooms_num }} <i class="fa-solid fa-house"></i></li>
                            <li class="me-3">{{ $apartment->beds_num }} <i class="fa-solid fa-bed"></i></li>
                            <li class="me-3">{{ $apartment->baths_num }} <i class="fa-solid fa-shower"></i></li>
                            <li class="me-3">{{ $apartment->mq }}mq <i class="fa-solid fa-ruler-combined"></i></li>   
                        </ul>
                        <div>
                            <p>{{ $apartment->description }}</p>
                        </div>
                </div>
            </div>
            {{-- sezione servizi singolo appartamento --}}
            <div class="container">
                <h5>Cosa troverai</h5>
                <div class="d-flex">
                    <ul class="me-3">
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                    </ul>
                    <ul>
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                        <li>Lorem ipsum dolor</li>
                    </ul>
                </div>
            </div>
            {{-- sezione mappa --}}
            <div class="container">
                <figure class="figure">
                    <img src="" class="figure-img img-fluid" alt="">
                    <figcaption class="figure-caption"><i class="fa-solid fa-location-dot"></i>{{ $apartment->full_address }}</figcaption>
                </figure>
            </div>
            {{-- bottoni --}}
            <div class=" container d-flex">
                <a class="btn btn-primary me-2" href="{{route ('admin.apartments.index') }}">Indietro</a>
                <a class="btn btn-secondary me-2" href="#">Modifica</a>
                <a class="btn btn-success me-2" href="#">Dai visibilità al tuo contenuto</a>
            </div>      
        </div>
    </div>
@endsection