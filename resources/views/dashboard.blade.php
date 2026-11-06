<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Digital & Analytics Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">POS Digital Analytics</h1>
        <span class="text-sm">Executive Dashboard</span>
    </nav>

    <div class="container mx-auto px-6 py-8">
        
        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-indigo-500">
                <p class="text-sm text-gray-500 font-medium">Total Pendapatan (Selesai)</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
                <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalOrders) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Total Katalog Produk</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts) }}</h3>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Grafik Pendapatan Bulanan</h2>
            <div class="relative h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script Configuration -->
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($data) !!},
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>