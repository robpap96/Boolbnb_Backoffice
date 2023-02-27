@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card" style="width: 430px; height: auto">
            <div class="card-body p-3 my-1">
                <h3 class="mb-4">{{ __('Reset della Password') }}</h3>

                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4 form-floating">
                        <input id="email" type="email" class="bg-light border-white ps-3 rounded-pill form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">
                        <label for="floatingInput" class="ms-1">Indirizzo E-mail</label>
                        @error('email')
                        <span class="invalid-feedback px-3 py-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                            {{ __('Invia Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
