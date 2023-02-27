@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card" style="width: 430px; height: auto">
                <div class="card-body p-4 my-1">
                    <h3 class="mb-1">{{ __('Accesso utente') }}</h3>
                    <small class="d-block mb-4">
                        Nuovo utente? 
                        <a class="text-decoration-none" href="{{ route('register') }}">Crea un account</a>
                    </small>

                    {{-- Form login --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email field --}}
                        <div class="mb-3 form-floating">
                            <input id="email" type="email" class="ps-3 bg-light border-white form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Indirizzo E-mail">
                            <label for="floatingInput" class="ms-1">Indirizzo E-mail</label>
                            @error('email')
                            <span class="invalid-feedback px-3 py-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- Password field --}}
                        <div class="mb-4 form-floating">
                            <input id="password" type="password" class="ps-3 bg-light border-white form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="floatingInput" class="ms-1">Password</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            {{-- Ricordami button --}}
                            <div>
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Ricordami') }}
                                </label>
                            </div>

                            {{-- Accedi button --}}
                            <div>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                                    {{ __('Accedi') }}
                                </button>
                            </div>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                    {{ __('Hai dimenticato la tua password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
