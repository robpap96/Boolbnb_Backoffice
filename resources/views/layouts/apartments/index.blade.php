<div class="card-container m-3 d-flex flex-column align-items-start">
    <div id="carousel-{{ $apartment->id }}" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ str_contains($apartment->image, 'uploads') ? asset("storage/{$apartment->image}") : $apartment->image}}" class="d-block w-100 apartment__image" alt="">
            </div>
            <div class="carousel-item active">
                <img src="{{ str_contains($apartment->image, 'uploads') ? asset("storage/{$apartment->image}") : $apartment->image}}" class="d-block w-100 apartment__image" alt="">
            </div>
        </div>
        <button class="carousel-control-prev d-none" type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none" type="button" data-bs-target="#carousel-{{ $apartment->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        @php
            $all_sponsors = $apartment->sponsorships->toArray();
            $sponsor_name = [];

            if( $all_sponsors !== [] ) {
                foreach ($all_sponsors as $sponsor) {
                    $date = new DateTime($sponsor['pivot']['sponsor_end']);
                    $now = new DateTime();
                    $now->format('Y-m-d H:i:s');  
    
                    if($date > $now) {
                        if( !in_array($sponsor['name'], $sponsor_name) ) {
                            $sponsor_name[] = $sponsor['name'];
                        }
                    }
                }
    
                if ( in_array('Platinum', $sponsor_name) ) {
                    echo "
                        <div class='sponsor-badge-icon text-center' style='color: rgb(229, 228, 226)'>
                            <i class='fa-solid fa-gem me-1'></i> PLATINUM
                        </div>
                    ";
                } else if ( in_array('Gold', $sponsor_name) ) {
                    echo "
                        <div class='sponsor-badge-icon text-center' style='color: #FFD700';'>
                            <i class='fa-solid fa-crown me-1'></i> GOLD
                        </div>
                    ";
                } else if( in_array('Silver', $sponsor_name) ) {
                    echo "
                        <div class='sponsor-badge-icon text-center text-secondary'>
                            <i class='fa-solid fa-medal me-1'></i> SILVER
                        </div>
                    ";
                }
            }
        @endphp
    </div>

    <div class="apartment__actions d-flex justify-content-between align-items-center w-100 mt-2 text-white py-2 px-3">
        <div><a href="{{ route('admin.apartments.show', $apartment->slug) }}"><i class="fa-solid fa-circle-info"></i> Info</a></div>
        <div class="edit-button px-4"><a href="{{ route('admin.apartments.edit', $apartment->slug) }}"><i class="fa-solid fa-wand-magic-sparkles"></i> Modifica</a></div>
        <!-- Button trigger modal -->
        <div type="div" class="t-4" data-bs-toggle="modal" data-bs-target="#modal{{ $apartment->id }}" style="cursor:pointer">
            <i class="fa-solid fa-trash-can"></i> Elimina
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="modal{{ $apartment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Stai per cancellare l'appartamento "{{ $apartment->title }}" con ID numero {{ $apartment->id }}.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-danger text-decoration-underline">
                        Sei sicuro ?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="apartment__info mb-2">
        <h5 class="mb-0">{{ $apartment->title }}</h5>
        <div class="text-muted py-1">{{ $apartment->full_address }}</div>
        <span><strong>{{ $apartment->price }}</strong> € /notte</span>
    </div>
</div>
