@extends('layouts.main-dashboard')

@section('page-title')
    | Nuovo appartamento
@endsection

@section('content')
    <div id="admin-apartments-create">
        <h1>Creazione di un nuovo appartamento</h1>

        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Titolo appartamento --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo riepilogativo che descriva l’appartamento*</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Titolo" minlength="5" maxlength="150">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Indirizzo completo --}}
            <div class="mb-3">
                <label for="full_address" class="form-label">Indirizzo completo*</label>
                <input type="text" id="full_address" name="full_address" class="form-control @error('full_address') is-invalid @enderror" value="{{ old('full_address') }}" placeholder="Indirizzo completo">
                @error('full_address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Numero di stanze --}}
            <div class="mb-3">
                <label for="rooms_num" class="form-label">Numero di stanze*</label>
                <input type="number" id="rooms_num" name="rooms_num" class="form-control @error('rooms_num') is-invalid @enderror" value="{{ old('rooms_num') }}" placeholder="Numero di stanze" min="1" max="15">
                @error('rooms_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Numero di letti --}}
            <div class="mb-3">
                <label for="beds_num" class="form-label">Numero di letti*</label>
                <input type="number" id="beds_num" name="beds_num" class="form-control @error('beds_num') is-invalid @enderror" value="{{ old('beds_num') }}" placeholder="Numero di letti" min="1" max="15">
                @error('beds_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Numero di bagni --}}
            <div class="mb-3">
                <label for="baths_num" class="form-label">Numero di bagni*</label>
                <input type="number" id="baths_num" name="baths_num" class="form-control @error('baths_num') is-invalid @enderror" value="{{ old('baths_num') }}" placeholder="Numero di bagni" min="1" max="15">
                @error('baths_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Metri quadrati totali --}}
            <div class="mb-3">
                <label for="mq" class="form-label">Metri quadrati totali*</label>
                <input type="number" id="mq" name="mq" class="form-control @error('mq') is-invalid @enderror" value="{{ old('mq') }}" placeholder="Metri quadrati" min="1" max="15000">
                @error('mq')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prezzo a notte --}}
            <div class="mb-3">
                <label for="price" class="form-label">Prezzo a notte*</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Prezzo" min="1" max="10000" step=".01">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Checkboxes with services --}}
            <div class="my-3 ">
                <div>
                    <label class="form-label">Lista servizi:</label>
                </div>
                @foreach ($services as $service)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="service-{{ $service->name }}" name="services[]" value="{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : null }}>
                        <label class="form-check-label" for="service-{{ $service->name }}}}">{{ $service->name }}</label>
                    </div>
                @endforeach
            </div>


            {{-- Descrizione appartamento --}}
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione*</label>
                <textarea name="description" id="description" cols="20" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Breve descrizione dell'appartamento">{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Immagine dell'appartamento --}}
            <div class="mb-3 d-flex">
                <div class="col-6">
                    <label for="image" class="form-label">Immagine rappresentativa dell’appartamento*</label>
                    <input type="file" id="image" name="image" class="form-control  @error('image') is-invalid @enderror" onchange="loadFile(event)">
                    @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 p-4">
                    <img id="output" src="" class="fluid-img w-100">
                </div>
    
                <script>
                    var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function(){
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    };
                </script>
            </div>

            {{-- Switch button per la visibilità si/no --}}
            @if ($errors->any())
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" {{ old('is_visible') ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_visible">Appartmento visibile si/no</label>
                </div>
            @else 
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" checked>
                    <label class="form-check-label" for="is_visible">Appartmento visibile si/no</label>
                </div>
            @endif

            <button type="submit" class="btn btn-success">Crea</button>
            <button type="reset" class="btn btn-secondary">Ripulisci tutti i campi</button>
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-danger">Annulla creazione</a>
        </form>
    </div>
@endsection