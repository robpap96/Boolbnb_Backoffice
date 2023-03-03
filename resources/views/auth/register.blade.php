@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="card" style="width: 800px; height: auto">
            <div class="card-body p-4 my-1">
                <h3 class="mb-1">{{ __('Registrazione nuovo utente') }}</h3>
                <small class="d-block mb-4">
                    Ti sei già registrato?
                    <a class="text-decoration-none" href="{{ route('login') }}">Accedi</a>
                </small>

                {{-- Form login --}}
                <form method="POST" action="{{ route('register') }}" class="row flex-columns">
                    @csrf
                    
                    <div class="col-sm-6 col-12 pe-sm--4 d-flex flex-column justify-content-around border-right">
                        <div class="form-floating">
                            <input id="name" type="text" class="bg-light border-white ps-3 rounded-pill form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="given-name" autofocus placeholder="Nome">
                            <label for="floatingInput" class="ms-1">Nome</label>
                            @error('name')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="form-floating">
                            <input id="last_name" type="text" class="bg-light border-white ps-3 rounded-pill form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" autofocus placeholder="Cognome">
                            <label for="floatingInput" class="ms-1">Cognome</label>
                            @error('last_name')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div>
                            <input id="date_of_birth" type="date" class="bg-light border-white p-3 rounded-pill form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="bday" autofocus>
                            @error('date_of_birth')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6 col-12 ps-sm-4 d-flex flex-column justify-content-around border-left">
                        <div class="form-floating">
                            <input id="email" type="email" class="bg-light border-white ps-3 rounded-pill form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail*">
                            <label for="floatingInput" class="ms-1">Indirizzo E-mail</label>
                            @error('email')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="form-floating">
                            <input id="password" type="password" class="bg-light border-white ps-3 rounded-pill form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password*">
                            <label for="floatingInput" class="ms-1">Password</label>
                            @error('password')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="form-floating">
                            <input id="password-confirm" type="password" class="bg-light border-white ps-3 rounded-pill form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Conferma Password*">
                            <label for="floatingInput" class="ms-1">Conferma Password</label>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                            {{ __('Registrati') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
