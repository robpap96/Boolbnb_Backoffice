@extends('layouts.main-dashboard')

@section('content')
    <div class="container">
        @foreach ($sponsorships as $sponsor)
        <div class="card">
            <img src="" alt="">
            <h2>{{ $sponsor->name }}</h2>
            <h3>{{ $sponsor->price }}</h3>
            <h4>{{ $sponsor->duration}}</h4>
        </div>
        @endforeach
    </div>
@endsection