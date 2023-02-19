@extends('layouts.main-dashboard')

@section('page-title')
    | Miei appartmenti
@endsection

@section('content')
    <div id="admin-apartments-index">
        @if ($apartments->isEmpty())
            {{-- fallback message if no apartment is present --}}
            <div class="alert alert-danger" role="alert">
                Pare che tu non abbia ancora creato un appartamento. <a href="{{ route('admin.apartments.create') }}" class="alert-link">Creane subito uno!</a>
            </div>
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
                        @php( $visible_apartments = [] )

                        @foreach ($apartments as $apartment)
                            @if ($apartment->is_visible == true)
                                @php( $visible_apartments[] = $apartment->id )

                                {{-- Layouts template HTMl blade --}}
                                @include('layouts.apartments.index', $apartment)
                            @endif
                        @endforeach

                        @if (count($visible_apartments) == 0)
                            <div class="alert alert-success mt-3" role="alert">
                                Nessun appartamento visibile.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Appartamenti non visibili tab --}}
                <div class="tab-pane fade" id="nav-hidden" role="tabpanel" aria-labelledby="nav-hidden-tab" tabindex="0">
                    <div class="d-flex flex-wrap justify-content-center">
                        @php( $hidden_apartments = [] )

                        @foreach ($apartments as $apartment)
                            @if ($apartment->is_visible == false)
                                @php( $hidden_apartments[] = $apartment->id )

                                {{-- Layouts template HTMl blade --}}
                                @include('layouts.apartments.index', $apartment)
                            @endif 
                        @endforeach

                        @if (count($hidden_apartments) == 0)
                            <div class="alert alert-success mt-3" role="alert">
                                Nessun appartamento nascosto.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection