@extends('layouts.main-dashboard')

@section('content')
    <div class="messages-container m-3">
        <div class="message_list_title text-center mb-3">
            <h1>I tuoi messaggi</h1>
        </div>
        
        @foreach ($messages as $message)
        <div class="col-12 mb-5">
            <div class="card" >
                <div class="card-body">
                  <h5 class="card-title">{{$message->email}}</h5>
                  <p class="card-text">{{ $message->content }}</p>
                  <a class="btn btn-success" href=" {{route('admin.apartments.show', $message->apartment_id)}}">Vedi l'appartamento</a>
    
                </div>
            </div>
        </div>
            @endforeach
    </div>
    @endsection