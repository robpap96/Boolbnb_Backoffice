@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card" style="width: 440px; height: auto">
            <div class="card-body p-4 my-1">
                <h3 class="mb-1">{{ __('Registrazione nuovo utente') }}</h3>
                <small class="d-block mb-4">
                    Ti sei già registrato?
                    <a class="text-decoration-none" href="{{ route('login') }}">Accedi</a>
                </small>

                {{-- Form login --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <input id="name" type="text" class="bg-light border-white px-3 py-2 rounded-pill form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="given-name" autofocus placeholder="Nome">
                        @error('name')
                        <span class="invalid-feedback px-3 py-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input id="last_name" type="text" class="bg-light border-white px-3 py-2 rounded-pill form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" autofocus placeholder="Cognome">
                        @error('last_name')
                        <span class="invalid-feedback px-3 py-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input id="date_of_birth" type="date" class="bg-light border-white px-3 py-2 rounded-pill form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="bday" autofocus>
                        @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input id="email" type="email" class="bg-light border-white px-3 py-2 rounded-pill form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail">
                        @error('email')
                        <span class="invalid-feedback px-3 py-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input id="password" type="password" class="bg-light border-white px-3 py-2 rounded-pill form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback px-3 py-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input id="password-confirm" type="password" class="bg-light border-white px-3 py-2 rounded-pill form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Conferma Password">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                            {{ __('Registrazione') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
