<!-- resources/views/map.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Depot</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet Search Plugin CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        #map { height: 80vh; width: 100%; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Pilih Depot Air Isi Ulang</h1>

        <!-- Search input -->
        <input type="text" id="searchInput" placeholder="Cari lokasi..." 
               class="w-full p-2 mb-4 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">

        <div id="map" class="rounded-lg shadow-md"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Control Geocoder (Search) -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        const addresses = @json($addresses);

        // Inisialisasi map
        const map = L.map('map');

        // Layer OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker layer group
        const markers = L.layerGroup().addTo(map);

        // Tambahkan semua marker
        addresses.forEach(addr => {
    // tampilkan hanya jika label === 'depot'
    if (
        addr.label === 'depot' &&
        addr.latitude &&
        addr.longitude
    ) {
        const marker = L.marker([addr.latitude, addr.longitude])
            .bindPopup(`
                <b>Depot</b><br>
                ${addr.alamat ?? addr.detail_alamat}<br>
                <button onclick="selectDepot(${addr.id})" 
                    class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Pilih Depot
                </button>
            `);

        markers.addLayer(marker);
    }
});


        // Fungsi pilih depot
        // Fungsi pilih depot
function selectDepot(id) {
    // Redirect ke route produk.index dengan address_id sebagai query string
    window.location.href = "{{ route('produk.index') }}" + "?address_id=" + id;
}


        // Coba ambil posisi user
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(pos => {
                const userLatLng = [pos.coords.latitude, pos.coords.longitude];
                const userMarker = L.marker(userLatLng, {title: "Lokasi Anda"}).addTo(map)
                                    .bindPopup("Anda berada di sini").openPopup();

                // Cari marker terdekat
                let nearestMarker = null;
                let minDistance = Infinity;
                markers.eachLayer(m => {
                    const d = map.distance(userLatLng, m.getLatLng());
                    if(d < minDistance){
                        minDistance = d;
                        nearestMarker = m;
                    }
                });

                if(nearestMarker){
                    map.setView(nearestMarker.getLatLng(), 15);
                    nearestMarker.openPopup();
                } else {
                    map.setView(userLatLng, 12);
                }
            }, () => {
                map.fitBounds(markers.getBounds());
            });
        } else {
            map.fitBounds(markers.getBounds());
        }

        // Search kontrol
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            const poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());
        })
        .addTo(map);

        // Optional: search input custom
        document.getElementById('searchInput').addEventListener('keypress', function(e){
            if(e.key === 'Enter'){
                geocoder.options.geocoder.geocode(this.value, results => {
                    if(results.length > 0){
                        const r = results[0];
                        map.setView(r.center, 15);
                    } else {
                        alert("Lokasi tidak ditemukan!");
                    }
                });
            }
        });
    </script>
</body>
</html>
