<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">POS Digital - Kasir</h1>
        <a href="{{ route('dashboard') }}" class="bg-indigo-700 px-4 py-2 rounded text-sm hover:bg-indigo-800">Lihat Dashboard</a>
    </nav>

    <div class="container mx-auto px-6 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Daftar Produk -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Katalog Produk</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <div class="border p-4 rounded-lg flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                <p class="text-indigo-600 font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('pos.store') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                                <input type="hidden" name="items[0][quantity]" value="1">
                                <input type="hidden" name="discount" value="0">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-medium hover:bg-indigo-700">
                                    Beli 1 Pcs
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Info Kasir / Panduan API -->
            <div class="bg-white p-6 rounded-xl shadow h-fit">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Informasi Transaksi</h2>
                <p class="text-gray-600 text-sm mb-4">
                    Klik tombol "Beli 1 Pcs" pada produk di sebelah kiri untuk mensimulasikan transaksi secara instan. Transaksi akan diproses melalui Service Layer atomik, mengurangi stok secara otomatis, dan langsung terakumulasi pada grafik pendapatan di Dashboard.
                </p>
                <div class="bg-gray-50 p-4 rounded border text-sm text-gray-600">
                    <p class="font-semibold mb-1">Fitur Terintegrasi:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Validasi stok anti-race condition (`lockForUpdate`)</li>
                        <li>Kalkulasi otomatis PPN 11% & Diskon</li>
                        <li>Dukungan RESTful API via Laravel Sanctum untuk Mobile/Tablet</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>