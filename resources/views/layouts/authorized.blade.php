<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-700">PT HNY</div>
            <nav class="flex flex-col p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="hover:bg-gray-700 p-2 rounded transition">📊 Dasbor
                    Visualisasi</a>
                <a href="{{ route('transaksi.index') }}" class="hover:bg-gray-700 p-2 rounded transition">🛒 Transaksi /
                    Pembelian</a>
                <a href="{{ route('riwayat.index') }}" class="hover:bg-gray-700 p-2 rounded transition">📜 Riwayat
                    Transaksi</a>
                <a href="{{ route('barang.index') }}" class="hover:bg-gray-700 p-2 rounded transition">📦 Kelola
                    Barang</a>
                <a href="{{ route('kategori.index') }}" class="hover:bg-gray-700 p-2 rounded">🏷️ Kategori</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
        @stack('scripts')
    </div>

</body>

</html>
