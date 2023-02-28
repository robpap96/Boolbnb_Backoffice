@extends('layouts.main-dashboard')

@section('content')
    <div id="admin-messages-index" class="messages-container m-3">
        @if ( $messages !== [] )
            <div class="message_list_title mb-3">
                <h2>Messaggi Ricevuti:</h2>
            </div>

            @foreach ($messages as $message)       
                <div class="col-12 mb-5">
                    <div class="apartment-details services mt-2 mb-4">
                        <h6 class="field p-1 px-3 text-center text-white d-flex justify-content-between">
                            <span>{{$message->email}}</span>
                            <span>{{$message->created_at}}</span>
                        </h6>
                        <div class="bg-light details-body h-100 py-3 px-3 d-flex flex-wrap justify-content-start align-items-center">
                            {{$message->content}}
                        </div>
                        <div class="div py-3">
                            <a class="btn btn-success" href="{{route('admin.apartments.show', $message->apartment )}}">Vedi l'appartamento <i class="fa-sharp fa-solid fa-eye"></i></a>
                            {{-- a scopo illustrativo --}}
                            <a class="btn btn-primary" href="mailto:{{ $message->email }}">Rispondi <i class="fa-solid fa-reply"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else 
            <div class="alert alert-warning">
                Nessun messaggio ricevuto.
            </div>
        @endif
    </div>
@endsection