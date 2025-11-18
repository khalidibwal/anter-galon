<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Toko Galon Terdekat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: auto;
            padding: 15px;
        }
        h1, h2 {
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #f4f6f8;
            margin-bottom: 15px;
            border-radius: 8px;
            padding: 15px;
        }
        .distance {
            color: #27ae60;
            font-weight: bold;
        }
        a.button {
            display: inline-block;
            background: #2980b9;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
        }
        a.button:hover {
            background: #1c5980;
        }
    </style>
</head>
<body>
    <h1>Toko Galon Terdekat</h1>
    <p>Lokasi Anda: Latitude {{ $userLat }}, Longitude {{ $userLon }}</p>

    <ul>
        @foreach ($stores as $store)
            <li>
                <strong>{{ $store['name'] }}</strong><br />
                {{ $store['address'] }}<br />
                <span class="distance">{{ number_format($store['distance'], 2) }} km dari lokasi Anda</span>
            </li>
        @endforeach
    </ul>

    <a href="/pilih-lokasi" class="button">Pilih Lokasi Lain</a>
</body>
</html>
