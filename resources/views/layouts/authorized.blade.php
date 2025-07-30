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
                <a href="{{ route('pengiriman.index') }}" class="hover:bg-gray-700 p-2 rounded transition">🚚
                    Pengiriman</a>
                <a href="{{ route('riwayat-pengiriman.index') }}" class="hover:bg-gray-700 p-2 rounded transition">📜
                    Riwayat Pengiriman</a>
                <a href="{{ route('kota.index') }}" class="hover:bg-gray-700 p-2 rounded transition">🏢 Kelola
                    Kota</a>
                <a href="{{ route('layanan.index') }}" class="hover:bg-gray-700 p-2 rounded transition">🏷️ Kelola
                    Layanan</a>
                <a href="{{ route('pelanggan.index') }}" class="hover:bg-gray-700 p-2 rounded transition">👤 Kelola
                    Pelanggan</a>
                <a href="{{ route('provinsi.index') }}" class="hover:bg-gray-700 p-2 rounded">🌏 Kelola Provinsi</a>
                <a href="{{ route('logout') }}" class="hover:bg-gray-700 p-2 rounded">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: '{{ $errors->first() }}',
                    });
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                    });
                });
            </script>
        @endif

    </div>

</body>

</html>
