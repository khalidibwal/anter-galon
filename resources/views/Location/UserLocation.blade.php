<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Lokasi User</title>

<!-- TailwindCSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    #map { 
        width: 100%;
        height: 60vh; 
        min-height: 320px; 
    }
</style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-4">

<div class="w-full bg-white shadow-md rounded-lg p-4">
    <h2 class="text-xl font-semibold mb-4 text-center">📍 Atur Lokasi Anda</h2>

    <form method="POST" action="{{ route('user.alamat.store') }}" id="lokasiForm">
        @csrf

        <!-- Koordinat -->
        <input type="hidden" id="lat" name="latitude" value="{{ $alamat->latitude ?? '' }}">
        <input type="hidden" id="lng" name="longitude" value="{{ $alamat->longitude ?? '' }}">

        <!-- Alamat hidden -->
        <input type="hidden" id="alamat" name="alamat" value="{{ $alamat->alamat ?? '' }}">

        <!-- Map -->
        <div id="map" class="rounded-lg overflow-hidden shadow mb-4"></div>

        <!-- Input alamat yang terlihat -->
        <div class="mb-3">
            <label class="block mb-1 font-medium text-gray-700">Alamat Terpilih</label>
            <input type="text" id="alamatText" 
                   class="w-full border rounded p-2 bg-gray-100" 
                   readonly 
                   placeholder="Alamat akan muncul di sini ketika marker dipilih"
                   value="{{ $alamat->alamat ?? '' }}">
        </div>

        <!-- Detail Alamat -->
        <label class="block mb-2 font-medium text-gray-700">Detail Alamat / Catatan</label>
        <textarea name="detail_alamat" id="detail_alamat" rows="3"
            class="w-full border rounded p-2 mb-4 focus:ring focus:ring-blue-300"
            placeholder="Contoh: jl. sehat no 2, Rumah cat hijau, pagar hitam, sebelah warung Bu Ani ...">{{ old('detail_alamat', $alamat->detail_alamat ?? '') }}</textarea>

        <!-- Waktu Pengantaran -->
        <label class="block mb-2 font-medium text-gray-700">Waktu Pengantaran</label>
        <input type="datetime-local" 
               name="waktu_pengantaran" 
               id="waktu_pengantaran"
               value="{{ old('waktu_pengantaran', $alamat->waktu_pengantaran ?? '') }}"
               class="w-full border rounded p-2 mb-4 focus:ring focus:ring-blue-300">

        <button type="submit" id="submitBtn" disabled
            class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded disabled:cursor-not-allowed">
            Simpan Lokasi
        </button>
    </form>
</div>

<div id="address" class="p-2 text-center text-gray-700 font-medium"></div>

<script>
var savedLat = "{{ $alamat->latitude ?? '' }}";
var savedLng = "{{ $alamat->longitude ?? '' }}";
var map, marker;

// ================================
// INIT MAP
// ================================
function initMap(lat, lng, zoom = 17) {
    map = L.map('map').setView([lat, lng], zoom);

    // Tile layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Marker
    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Update alamat awal
    updateLocation(lat, lng);

    // Drag marker
    marker.on('dragend', function(e) {
        let pos = e.target.getLatLng();
        updateLocation(pos.lat, pos.lng);
    });

    // Klik map
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);
    });
}

// ================================
// UPDATE LOCATION & ADDRESS
// ================================
function updateLocation(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            let displayAddress = data.display_name || '';

            // Update input visible
            document.getElementById('alamatText').value = displayAddress;

            // Update input hidden
            document.getElementById('alamat').value = displayAddress;

            // Update di bawah peta
            document.getElementById('address').textContent = displayAddress;

            // Update popup marker
            marker.bindPopup(displayAddress).openPopup();
        })
        .catch(err => {
            console.log("Error fetching address:", err);
        });
}

// ================================
// DETECT DEVICE & INIT
// ================================
function detectDeviceAndInit() {
    if (savedLat && savedLng) {
        initMap(parseFloat(savedLat), parseFloat(savedLng), 17);
    } else if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                initMap(pos.coords.latitude, pos.coords.longitude, 17);
            },
            function(err) {
                console.log("GPS Error:", err);
                initMap(-6.2000, 106.8166, 13);
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    } else {
        initMap(-6.2000, 106.8166, 13);
    }
}

// ================================
// FORM VALIDATION
// ================================
const detailAlamat = document.getElementById('detail_alamat');
const waktuPengantaran = document.getElementById('waktu_pengantaran');
const submitBtn = document.getElementById('submitBtn');

function validateForm() {
    if (detailAlamat.value.trim() !== "" && waktuPengantaran.value !== "") {
        submitBtn.disabled = false;
        submitBtn.classList.remove('bg-gray-400');
        submitBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
        submitBtn.classList.add('bg-gray-400');
    }
}

detailAlamat.addEventListener('input', validateForm);
waktuPengantaran.addEventListener('input', validateForm);

// Jalankan
detectDeviceAndInit();
validateForm();
</script>

</body>
</html>
