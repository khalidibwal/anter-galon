<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pilih Lokasi Anda</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link rel="stylesheet" href="{{ asset('css/map.css') }}">

</head>

<body>
    <h1>Pilih Lokasi Anda</h1>

    <label for="address">Cari alamat:</label>
    <input type="text" id="address" placeholder="Masukkan alamat" />
    <button id="searchBtn" type="button">Cari</button>

    <div id="map"></div>

    <form method="POST" action="/pilih-lokasi" id="locationForm">
        @csrf
        <input type="hidden" name="latitude" id="latitude" required />
        <input type="hidden" name="longitude" id="longitude" required />
        <button type="submit">Kirim Lokasi</button>
    </form>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
    const map = L.map('map').setView([-6.200000, 106.816666], 13); // Default Jakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    let marker;

    function setMarker(lat, lon) {
        if (marker) {
            marker.setLatLng([lat, lon]);
        } else {
            marker = L.marker([lat, lon], { draggable: true }).addTo(map);
            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                updateInputs(pos.lat, pos.lng);
            });
        }
        map.setView([lat, lon], 15);
        updateInputs(lat, lon);
    }

    function updateInputs(lat, lon) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
    }

    document.getElementById('searchBtn').addEventListener('click', () => {
        const query = document.getElementById('address').value;
        if (!query) return alert('Masukkan alamat dulu');

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const place = data[0];
                    setMarker(place.lat, place.lon);
                } else {
                    alert('Alamat tidak ditemukan');
                }
            })
            .catch(() => alert('Error mencari alamat'));
    });

    // 🌍 Tambahkan fitur lokasi pengguna
    if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(
    function (position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        setMarker(lat, lon);
    },
    function (error) {
        console.warn('Gagal mendapatkan lokasi:', error.message);
        setMarker(-6.200000, 106.816666); // fallback ke Jakarta
    },
    {
        enableHighAccuracy: true, // 🔍 ini penting untuk akurasi tinggi
        timeout: 10000,
        maximumAge: 0
    }
);

    } else {
        alert('Geolocation tidak didukung browser ini.');
        setMarker(-6.200000, 106.816666); // fallback default
    }
</script>

</body>
</html>
