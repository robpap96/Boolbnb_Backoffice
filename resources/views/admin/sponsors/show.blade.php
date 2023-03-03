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
            
            <div class="payments w-75 m-auto">
                <div id="dropin-container"></div>
                <button type="button" id="submit-button" class="btn btn-success">Aquista {{ $sponsor->price }} €</button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">Indietro</a>
            </div>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.35.0/js/dropin.js"></script>
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
        authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
        selector: '#dropin-container'
        }, function (err, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    if ( payload !== undefined ) {
                        // Pagamento andato a buon fine
                        let paymenSubmitButton = document.getElementById('submit-button');
                        paymenSubmitButton.type = 'submit';
                        paymenSubmitButton.click();
                    } else {
                        // Pagamento non andato a buon fine
                        console.log('compila i campi !')
                    }
                });
            })
        });
    </script>
@endsection