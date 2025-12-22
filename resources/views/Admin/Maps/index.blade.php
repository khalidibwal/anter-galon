@extends('Component.Landing.AdminLayout') {{-- sesuaikan --}}

@section('content')
<div class="bg-white p-6 rounded shadow max-w-xl">

    <h1 class="text-xl font-semibold mb-4 bg-white text-gray-900">Lokasi Depot Galon</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.depot.lokasi.update') }}" method="POST">
        @csrf

        <div id="map" class="w-full h-64 rounded mb-4"></div>

        <!-- Alamat otomatis -->
        <div class="mb-3">
            <label class="text-sm font-medium bg-white text-gray-900">Alamat Depot</label>
            <input type="text" id="alamat" name="alamat"
                   class="w-full rounded border-gray-300 bg-white text-gray-900"
                   readonly
                   value="{{ $depot->alamat ?? '' }}">
        </div>

        <!-- Catatan -->
        <div class="mb-3">
            <label class="text-sm font-medium bg-white text-gray-900">Detail Depot</label>
            <textarea name="detail_alamat"
                      class="w-full rounded border-gray-300 bg-white text-gray-900"
                      placeholder="Contoh: dekat SPBU">{{ $depot->detail_alamat ?? '' }}</textarea>
        </div>

        <input type="hidden" id="latitude" name="latitude"
               value="{{ $depot->latitude ?? -6.200000 }}">
        <input type="hidden" id="longitude" name="longitude"
               value="{{ $depot->longitude ?? 106.816666 }}">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan Lokasi Depot
        </button>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let lat = {{ $depot->latitude ?? -6.200000 }};
let lng = {{ $depot->longitude ?? 106.816666 }};

let map = L.map('map').setView([lat, lng], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

// klik peta
map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    updateLocation(e.latlng.lat, e.latlng.lng);
});

// drag marker
marker.on('dragend', function(e) {
    let pos = e.target.getLatLng();
    updateLocation(pos.lat, pos.lng);
});

function updateLocation(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('alamat').value =
                data.display_name || '';
        });
}
</script>
@endsection
