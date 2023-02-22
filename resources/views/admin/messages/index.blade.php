@extends('layouts.main-dashboard')

@section('content')
    <div class="messages-container">
        <div class="message_list_title text-center mb-3">
            <h1>I tuoi messaggi</h1>
        </div>
        @foreach ($messages as $message)
            <div class="message-card m-2 d-flex">
                <div class="message-image-box">
                    <div class="message-type {{$message->email}}"><h4>{{$message->email}}</h4></div>
                    <p>{{ $message->content }}</p>
                </div>
            </div>
            <a class="btn btn-success" href=" {{route('admin.apartments.show', $message->apartment_id)}}">Vedi l'appartamento</a>
            @endforeach
    </div>
    @endsection