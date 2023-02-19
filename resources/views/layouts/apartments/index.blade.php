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
    </div>

    <div class="apartment__actions d-flex justify-content-between align-items-center w-100 mt-2 text-white py-2 px-3">
        <div><a href="{{ route('admin.apartments.show', $apartment->id) }}"><i class="fa-solid fa-circle-info"></i> Info</a></div>
        <div class="edit-button px-4"><i class="fa-solid fa-wand-magic-sparkles"></i> Modifica</div>
        <div><i class="fa-solid fa-trash-can"></i> Elimina</div>
    </div>

    <div class="apartment__info mb-2">
        <h5 class="mb-0">{{ $apartment->title }}</h5>
        <div class="text-muted py-1">{{ $apartment->full_address }}</div>
        <span><strong>{{ $apartment->price }}</strong> € /notte</span>
    </div>
</div>
