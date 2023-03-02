@extends('layouts.main-dashboard')

@section('content')
    <div id="admin-messages-index" class="messages-container m-3">
        @if ( $messages !== [] )
            <div class="message_list_title mb-3">
                <h2 class="text-center">Messaggi Ricevuti</ class="text-center">
            </div>

            <div class="d-flex flex-column-reverse">
                @foreach ($messages as $message)       
                    <div class="col-12">
                        <div class="message-details services mt-2 mb-4">
                            <h6 class="field py-2 px-3 text-center text-white d-flex justify-content-between">
                                <span class="fs-6">{{$message->email}}</span>
                                <span class="fs-6">{{$message->created_at}}</span>
                            </h6>
                            <div class="bg-light details-body h-100 py-3 px-3 d-flex flex-wrap aling-item-start justify-content-center flex-column">
                                {{$message->content}}
    
    
                                <div class="div pt-3 pb-1 d-flex justify-content-between align-items-center">
                                    <div class="d-flex">
                                        <a class="my-btn btn-show-apartment" href="{{route('admin.apartments.show', $message->apartment )}}">Vedi l'appartamento <i class="fa-sharp fa-solid fa-eye"></i></a>
                                        {{-- a scopo illustrativo --}}
                                        <a class="my-btn btn-reply" href="mailto:{{ $message->email }}">Rispondi <i class="fa-solid fa-reply"></i></a>
                                    </div>
                                    <div class="text-decoration-underline">
                                        <strong>Inviato da: </strong>{{ $message->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else 
            <div class="alert alert-warning text-center">
                Nessun messaggio ricevuto.
            </div>
        @endif
    </div>
@endsection