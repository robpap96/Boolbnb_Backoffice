@extends('layouts.main-dashboard')

@section('content')
    <div id="admin-messages-index" class="messages-container m-3">
        <div class="message_list_title mb-3">
            <h2>Messaggi Ricevuti:</h2>
        </div>

        @foreach ($messages as $message)
            @if ( $message['apartment']['user_id'] === $user_id )
            <div class="col-12 mb-5">
                <div class="card" >
                    <div class="card-body mask-custom p-3">
                        <h5 class="card-title mb-2">{{$message->email}}</h5>
                        <p class="text small mb-0"><i class="far fa-clock"></i> Ricevuto il {{$message->created_at}}</p>
                        <p class="card-text p-4">{{ $message->content }}</p>
                        <div class="div">
                            <a class="btn btn-success" href="{{route('admin.apartments.show', $message->apartment )}}">Vedi l'appartamento <i class="fa-sharp fa-solid fa-eye"></i></a>
                            {{-- a scopo illustrativo --}}
                            <a class="btn btn-primary" href="mailto:{{ $message->email }}">Rispondi <i class="fa-solid fa-reply"></i></a>
                        </div>


                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    @endsection