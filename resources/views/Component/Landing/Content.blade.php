<main class="py-12 px-4 container mx-auto">
    {{-- Hero Section --}}
    <section class="text-center mb-16">
        <h2 class="text-4xl font-bold mb-4 text-blue-700">Air Galon Isi Ulang Berkualitas</h2>
        <p class="text-lg text-gray-600">Nikmati kesegaran air murni, aman untuk keluarga Anda. Antar langsung ke rumah!</p>
        <a href="{{ route('produk.index') }}" class="mt-6 inline-block bg-blue-600 text-white py-3 px-6 rounded hover:bg-blue-700">Pesan Sekarang</a>
    </section>

    {{-- Layanan --}}
    <section id="layanan" class="mb-16">
        <h3 class="text-2xl font-semibold mb-6 text-center text-blue-700">Layanan Kami</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow p-6 rounded">
                <h4 class="text-xl font-bold mb-2">Isi Ulang Galon</h4>
                <p>Air minum RO siap konsumsi dengan standar kualitas tinggi.</p>
            </div>
            <div class="bg-white shadow p-6 rounded">
                <h4 class="text-xl font-bold mb-2">Antar Jemput Galon</h4>
                <p>Kami antar galon ke rumah Anda dengan cepat dan tepat waktu.</p>
            </div>
            <div class="bg-white shadow p-6 rounded">
                <h4 class="text-xl font-bold mb-2">Langganan Bulanan</h4>
                <p>Layanan berlangganan praktis dengan harga hemat untuk keluarga.</p>
            </div>
        </div>
    </section>

    {{-- Tentang --}}
    <section id="about" class="mb-16">
        <h3 class="text-2xl font-semibold mb-4 text-center text-blue-700">Tentang Kami</h3>
        <p class="max-w-2xl mx-auto text-center text-gray-600">
            Kami adalah penyedia layanan air minum isi ulang terpercaya di kota Anda. Berkomitmen menyediakan air berkualitas tinggi dengan layanan terbaik.
        </p>
    </section>
</main>
