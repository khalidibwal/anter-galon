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

    <!-- Leaflet Search Plugin -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

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

        <!-- Alamat otomatis dari geocoder -->
        <input type="hidden" id="alamat" name="alamat" value="{{ $alamat->alamat ?? '' }}">

        <div id="map" class="rounded-lg overflow-hidden shadow mb-4"></div>

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
    // TILE LAYER GOOGLE MAP
    // ================================
    function setTileLayer() {
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
    }

    // ================================
    // SEARCH BAR
    // ================================
    function addSearchControl() {
        var searchControl = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari lokasi...",
            geocoder: L.Control.Geocoder.nominatim()
        })
        .on("markgeocode", function(e) {
            var center = e.geocode.center;
            map.setView(center, 18);
            updateMarkerAndAddress(center);
        })
        .addTo(map);
    }

    // ================================
    // INIT MAP
    // ================================
    function initMap(lat, lng, zoom = 17) {
        map = L.map('map').setView([lat, lng], zoom);
        setTileLayer();

        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        updateMarkerAndAddress({ lat: lat, lng: lng });

        addSearchControl();

        // Drag marker
        marker.on('dragend', function(e) {
            updateMarkerAndAddress(e.target.getLatLng());
        });

        // Klik map
        map.on('click', function(e) {
            updateMarkerAndAddress(e.latlng);
        });
    }

    // ================================
    // REVERSE GEOCODER
    // ================================
    var geocoder = L.Control.Geocoder.nominatim({ geocodingQueryParams: { addressdetails: 1 } });

    function updateMarkerAndAddress(latlng) {
        marker.setLatLng(latlng);
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;

        geocoder.reverse(latlng, map.getZoom(), function(results) {
            var r = results && results[0];
            if (r) {
                marker.bindPopup(r.name).openPopup();
                document.getElementById('address').textContent = r.name;
                document.getElementById('alamat').value = r.name;
            }
        });
    }

    // ================================
    // PRIORITAS LOKASI
    // ================================
    function detectDeviceAndInit() {
        if (savedLat && savedLng) {
            initMap(parseFloat(savedLat), parseFloat(savedLng), 17);
        } else if ("geolocation" in navigator) {
            var isMobile = /Mobi|Android/i.test(navigator.userAgent);

            if (isMobile) {
                navigator.geolocation.watchPosition(
                    function(pos) {
                        var lat = pos.coords.latitude;
                        var lng = pos.coords.longitude;

                        if (!map) initMap(lat, lng, 18);
                        else {
                            marker.setLatLng([lat, lng]);
                            map.setView([lat, lng]);
                        }

                        updateMarkerAndAddress({ lat: lat, lng: lng });
                    },
                    function(err) {
                        console.log("GPS Error:", err);
                        initMap(-6.2000, 106.8166, 13);
                    },
                    { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 }
                );
            } else {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        initMap(pos.coords.latitude, pos.coords.longitude, 17);
                        updateMarkerAndAddress({ lat: pos.coords.latitude, lng: pos.coords.longitude });
                    },
                    function(err) {
                        console.log("GPS Error:", err);
                        initMap(-6.2000, 106.8166, 13);
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            }
        } else {
            initMap(-6.2000, 106.8166, 13);
        }
    }

    // ================================
    // VALIDASI FORM
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
    validateForm(); // cek awal
</script>

</body>
</html>
