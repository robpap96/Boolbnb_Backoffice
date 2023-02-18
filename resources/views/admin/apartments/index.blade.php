@extends('layouts.main-dashboard')

@section('page-title')
    | Miei appartmenti
@endsection

@section('content')
    <div id="admin-apartments-index">
        @if ($apartments->isEmpty())
        {{-- fallback message if no apartment is present --}}
        <h2>Nessun appartamento aggiunto, creane subito uno!</h2>
        @else
        <div class="d-flex flex-wrap justify-content-center">
            @foreach ($apartments as $apartment)
                <div class="card-container m-3">
                    <div id="carousel-{{ $apartment->id }}" class="carousel slide">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ str_contains($apartment->image, 'uploads') ? asset("storage/{$apartment->image}") : $apartment->image}}" class="d-block w-100" alt="">
                            </div>
                            <div class="carousel-item active">
                                <img src="{{ str_contains($apartment->image, 'uploads') ? asset("storage/{$apartment->image}") : $apartment->image}}" class="d-block w-100" alt="">
                            </div>
                            <div class="carousel-item active">
                                <img src="{{ str_contains($apartment->image, 'uploads') ? asset("storage/{$apartment->image}") : $apartment->image}}" class="d-block w-100" alt="">
                            </div>
                        </div>
                        <button class="carousel-control-prev d-none" type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next d-none" type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="apartment__info">
                        <h5 class="mb-0">{{ $apartment->title }}</h5>
                        <div class="text-muted py-1">{{ $apartment->full_address }}</div>
                        <span><strong>{{ $apartment->price }}</strong> € /notte</span>
                    </div>
                    <div class="text-white text-center mt-1 {{ $apartment->is_visible ? 'bg-success' : 'bg-danger'}}">{{ $apartment->is_visible ? 'Appartamento visibile' : 'Appartamento nascosto'}}</div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
@endsection