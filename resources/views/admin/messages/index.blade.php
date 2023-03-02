@extends('layouts.main-dashboard')

@section('content')
    <div id="admin-messages-index" class="messages-container m-3">
        @if ( $messages !== [] )
            <div class="message_list_title mb-3">
                <h1 class="m-text-cursive text-center">Messaggi Ricevuti</h1>
            </div>

            {{-- Apartments accordion --}}
            @foreach ($my_apartments as $my_apartment)
                @if ( !$my_apartment->messages->isEmpty() )
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading-{{ $my_apartment->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{ $my_apartment->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse-{{ $my_apartment->id }}">
                                    <div>
                                        {{ $my_apartment->title }} | {{ $my_apartment->full_address }} 
                                    </div>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapse-{{ $my_apartment->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-{{ $my_apartment->id }}">
                                <div class="accordion-body d-flex flex-column-reverse">
                                    <div class="d-flex justify-content-end">
                                        <a class="my-btn btn-show-apartment" href="{{route('admin.apartments.show', $my_apartment )}}">Vedi l'appartamento <i class="fa-sharp fa-solid fa-eye"></i></a>
                                    </div>
                                    @foreach ($messages as $message)
                                        @if ( $message->apartment_id === $my_apartment->id)
                                            <div class="col-12">
                                                <div class="message-details services mt-2 mb-4">
                                                    <h6 class="field py-2 px-3 text-center text-white d-flex justify-content-between">
                                                        <span class="fs-6">{{$message->email}}</span>
                                                        <span class="fs-6">{{$message->created_at}}</span>
                                                    </h6>
                                                    <div class="bg-light details-body h-100 py-3 px-3 d-flex flex-wrap aling-item-start justify-content-center flex-column">
                                                        {{ $message->content }}
                                                        <div class="div pt-3 pb-1 d-flex justify-content-between align-items-center">
                                                            <div class="d-flex">
                                                                {{-- a scopo illustrativo --}}
                                                                <a class="my-btn btn-reply" href="mailto:{{ $message->email }}?subject=In Risposta al tuo quesito | BoolBnB&body=Riferimento messaggio ricevuto: {{ $message->content }}. Risposta: ">Rispondi <i class="fa-solid fa-reply"></i></a>
                                                            </div>
                                                            <div class="text-decoration-underline">
                                                                <strong>Inviato da: </strong>{{ $message->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="text-muted ps-1">
                                        @if ( count($my_apartment->messages) > 1 )
                                            {{ count($my_apartment->messages) }} messaggi ricevuti
                                        @else 
                                            {{ count($my_apartment->messages) }} messaggio ricevuto
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else 
            <div class="alert alert-warning text-center">
                Nessun messaggio ricevuto.
            </div>
        @endif
    </div>
@endsection