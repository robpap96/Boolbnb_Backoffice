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
            <nav class="apartments-tabs">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active w-50 text-dark" id="nav-visible-tab" data-bs-toggle="tab" data-bs-target="#nav-visible" type="button" role="tab" aria-controls="nav-visible" aria-selected="true">Appartamenti visibili</button>
                <button class="nav-link w-50 text-dark" id="nav-hidden-tab" data-bs-toggle="tab" data-bs-target="#nav-hidden" type="button" role="tab" aria-controls="nav-hidden" aria-selected="false">Appartamenti non visibili</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                {{-- Appartamenti visibili tab --}}
                <div class="tab-pane fade show active" id="nav-visible" role="tabpanel" aria-labelledby="nav-visible-tab" tabindex="0">
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach ($apartments as $apartment)
                            @if ($apartment->is_visible == true)
                            {{-- Layouts template HTMl blade --}}
                                @include('layouts.apartments.index', $apartment) 
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Appartamenti non visibili tab --}}
                <div class="tab-pane fade" id="nav-hidden" role="tabpanel" aria-labelledby="nav-hidden-tab" tabindex="0">
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach ($apartments as $apartment)
                            @if ($apartment->is_visible == false)
                                {{-- Layouts template HTMl blade --}}
                                @include('layouts.apartments.index', $apartment)
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection