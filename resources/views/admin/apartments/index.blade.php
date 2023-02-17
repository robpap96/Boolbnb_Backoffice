@extends('layouts.app')

@section('content')
    <section id="admin-apartments-index" class="d-flex container" style="height: calc(100vh - 66px)">
        <div class="col-3 left-column">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white m-2
                    {{ str_contains(Route::currentRouteName(), 'admin.apartments.index') ? 'bg-color-red' : '' }}"
                    href="{{route('admin.apartments.index')}}">
                        <i class="fa-solid fa-house-user fa-lg fa-fw me-2"></i>I miei appartamenti
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-9 right-column p-2">
            @if ($apartments->isEmpty())
                {{-- fallback message if no apartment is present --}}
                <h2>Nessun appartamento aggiunto, Inizia subito!</h2>
            @else
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach ($apartments as $apartment)
                        <div class="card-container m-3">
                            <img class="apartment__image" src="{{ $apartment->image }}" alt="">
                            <div class="apartment__info">
                                <h5 class="mb-0">{{ $apartment->title }}</h5>
                                <div class="text-muted py-1">{{ $apartment->full_address }}</div>
                                <span><strong>{{ $apartment->price }}</strong> € /notte</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection