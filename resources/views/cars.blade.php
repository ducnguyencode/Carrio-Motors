@extends('layouts.app')

@section('content')
<div class="container mt-4 position-relative">
    <input
        id="search-input"
        type="text"
        class="form-control"
        placeholder="Search cars by name or brand..."
        onfocus="this.select();"
    >
    <ul id="search-results" class="list-group position-absolute w-100 z-10" style="max-height: 200px; overflow-y: auto;"></ul>
</div>

<h2 class="mt-4">Available Cars</h2>
<div class="row">
    @foreach ($cars as $car)
    <div class="col-md-4 mb-4">
        <div class="card car-card" data-id="{{ $car->id }}" data-name="{{ $car->name }}" data-brand="{{ $car->brand }}" data-image="{{ $car->image_url }}" data-seats="{{ $car->seat_number }}">
            <img src="{{ $car->image_url }}" class="card-img-top" alt="{{ $car->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $car->name }}</h5>
                <p class="card-text">Brand: {{ $car->brand }} | Seats: {{ $car->seat_number }}</p>
                <a href="/cars/{{ $car->id }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="carDetailModal" tabindex="-1" aria-labelledby="carDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carDetailModalLabel">Car Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="modal-car-image" src="" class="img-fluid mb-3" alt="">
        <h4 id="modal-car-name"></h4>
        <p id="modal-car-brand"></p>
        <p id="modal-car-seats"></p>
      </div>
      <div class="modal-footer">
        <a href="#" id="modal-view-link" class="btn btn-primary">View Full Details</a>
      </div>
    </div>
  </div>
</div>

<script>
let debounceTimer;
const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const query = searchInput.value.trim();
        if (query.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        fetch(`/search/cars?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                searchResults.innerHTML = '';
                if (data.length === 0) {
                    searchResults.innerHTML = '<li class="list-group-item">No results found.</li>';
                    return;
                }

                data.forEach(car => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.innerHTML = `
                        <img src="${car.image_url}" alt="${car.name}" width="50" class="me-2">
                        ${car.name} - ${car.brand}
                    `;
                    li.onclick = () => window.location.href = `/cars/${car.id}`;
                    searchResults.appendChild(li);
                });
            });
    }, 400);
});

let modalOpenedFor = null;
document.querySelectorAll('.car-card').forEach(card => {
    card.addEventListener('click', function (e) {
        const carId = this.getAttribute('data-id');

        if (modalOpenedFor === carId) {
            window.location.href = `/cars/${carId}`;
            return;
        }

        modalOpenedFor = carId;
        document.getElementById('modal-car-image').src = this.getAttribute('data-image');
        document.getElementById('modal-car-name').textContent = this.getAttribute('data-name');
        document.getElementById('modal-car-brand').textContent = 'Brand: ' + this.getAttribute('data-brand');
        document.getElementById('modal-car-seats').textContent = 'Seats: ' + this.getAttribute('data-seats');
        document.getElementById('modal-view-link').href = `/cars/${carId}`;
        new bootstrap.Modal(document.getElementById('carDetailModal')).show();
    });
});
</script>
@endsection
