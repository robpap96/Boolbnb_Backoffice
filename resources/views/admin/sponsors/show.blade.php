@extends('layouts.main-dashboard')

@section('content')
    <div class="sponsor-container show">
        <div class="sponsor_list_title text-center mb-3">
            <h1 class="m-text-cursive m-3">Completa l'acquisto !</h1>
        </div>
        {{-- Sponsor card with apartments select --}}
        <div class="sponsor-card m-2">
            <div class="sponsor-image-box text-center">
                <img class="sponsor-image {{$sponsor->name}}" src="{{ Vite::asset('resources/img/IMG-20230220-WA0002_origin.png')}}" alt="" width="150px" height="150px">
                <div class="sponsor-type {{$sponsor->name}}"><h4>{{$sponsor->name}}</h4></div>
            </div>

            <form id="sponsors-buy-form" action="{{ route('admin.sponsors.buy', $sponsor->name) }}">
                <select name="apartment_sponsored" id="" class="form-select" aria-label="">
                    <option value="" selected hidden>Scegliere un appartamento da sponsorizzare</option>
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
            </form>

            <div class="mt-3 alert alert-warning">
                <small><strong>Nota bene:</strong> Gli appartamenti non visibili non potranno essere sponsorizzati.</small>
            </div>

        </div>

        {{-- Make payment container --}}
        <div class="payments"> 
            <div class="form-container m-2">
                <form id="my-sample-form" class="scale-down">
                    <h2 class="text-center mb-4">Dettagli Pagamento</h2>
                    <div class="cardinfo-card-number">
                        <label class="cardinfo-label" for="card-number">Numero identificativo carta</label>
                        <div class='input-wrapper' id="card-number"></div>
                        <div id="card-image"></div>
                    </div>
                
                    <div class="cardinfo-wrapper">
                        <div class="cardinfo-exp-date">
                        <label class="cardinfo-label" for="expiration-date">Valida fino al </label>
                        <div class='input-wrapper' id="expiration-date"></div>
                        </div>
                
                        <div class="cardinfo-cvv">
                        <label class="cardinfo-label" for="cvv">CVV</label>
                        <div class='input-wrapper' id="cvv"></div>
                        </div>
                    </div>
                </form>
                
                <input id="button-pay" class="btn btn-primary mb-3" type="submit" value="Acquista per {{$sponsor->price}} €" />
            </div>
        </div>

        {{-- Payment confirm --}}
        @if (session('message'))
            <div id="toast-payment" class="toast align-items-center show w-auto" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="fa-solid fa-check fa-fw fa-lg me-1"></i>
                    <span>
                        {{ session('message') }}
                    </span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- Logic card payments --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.91.0/js/hosted-fields.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.91.0/js/client.min.js"></script>
    <script>
        var form = document.querySelector('#my-sample-form');
        var submit = document.querySelector('input[type="submit"]');

        braintree.client.create({
        authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b'
        }, function (err, clientInstance) {
        if (err) {
            console.error(err);
            return;
        }

        // Create input fields and add text styles  
        braintree.hostedFields.create({
            client: clientInstance,
            styles: {
            'input': {
                'color': '#282c37',
                'font-size': '16px',
                'transition': 'color 0.1s',
                'line-height': '3'
            },
            // Style the text of an invalid input
            'input.invalid': {
                'color': '#E53A40'
            },
            // placeholder styles need to be individually adjusted
            '::-webkit-input-placeholder': {
                'color': 'rgba(0,0,0,0.6)'
            },
            ':-moz-placeholder': {
                'color': 'rgba(0,0,0,0.6)'
            },
            '::-moz-placeholder': {
                'color': 'rgba(0,0,0,0.6)'
            },
            ':-ms-input-placeholder': {
                'color': 'rgba(0,0,0,0.6)'
            },
            // prevent IE 11 and Edge from
            // displaying the clear button
            // over the card brand icon
            'input::-ms-clear': {
                opacity: '0'
            }
            },
            // Add information for individual fields
            fields: {
            number: {
                selector: '#card-number',
                placeholder: '**** **** **** ****'
            },
            cvv: {
                selector: '#cvv',
                placeholder: '***'
            },
            expirationDate: {
                selector: '#expiration-date',
                placeholder: 'MM / YYYY'
            }
            }
        }, function (err, hostedFieldsInstance) {
            if (err) {
            console.error(err);
            return;
            }

            hostedFieldsInstance.on('validityChange', function (event) {
            // Check if all fields are valid, then show submit button
            var formValid = Object.keys(event.fields).every(function (key) {
                return event.fields[key].isValid;
            });

            if (formValid) {
                $('#button-pay').addClass('show-button');
            } else {
                $('#button-pay').removeClass('show-button');
            }
            });

            hostedFieldsInstance.on('empty', function (event) {
            $('header').removeClass('header-slide');
            $('#card-image').removeClass();
            $(form).removeClass();
            });

            hostedFieldsInstance.on('cardTypeChange', function (event) {
            // Change card bg depending on card type
            if (event.cards.length === 1) {
                $(form).removeClass().addClass(event.cards[0].type);
                $('#card-image').removeClass().addClass(event.cards[0].type);
                $('header').addClass('header-slide');
                
                // Change the CVV length for AmericanExpress cards
                if (event.cards[0].code.size === 4) {
                hostedFieldsInstance.setAttribute({
                    field: 'cvv',
                    attribute: 'placeholder',
                    value: '1234'
                });
                } 
            } else {
                hostedFieldsInstance.setAttribute({
                field: 'cvv',
                attribute: 'placeholder',
                value: '123'
                });
            }
            });

            submit.addEventListener('click', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (err, payload) {
                if (err) {
                    console.error(err);
                    return;
                }

                // This is where you would submit payload.nonce to your server
                // alert('Submit your nonce to your server here!');
                let sponsorsBuyForm = document.getElementById('sponsors-buy-form');

                sponsorsBuyForm.submit();
            });
            }, false);
        });
        });
    </script>
@endsection