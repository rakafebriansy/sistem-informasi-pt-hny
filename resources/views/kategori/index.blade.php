@extends('layouts.authorized')

@section('title')
    PT HNY - Kategori
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-semibold text-gray-800">Kelola Kategori</h1>
    <button onclick="toggleModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
        + Tambah Kategori
    </button>
</div>

<!-- Alert -->
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<!-- Tabel -->
<div class="overflow-x-auto bg-white rounded-lg shadow p-4">
    <table id="kategori-table" class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700 uppercase">
            <tr>
                <th class="px-4 py-3 border-b">ID</th>
                <th class="px-4 py-3 border-b">Nama</th>
                <th class="px-4 py-3 border-b">Dibuat</th>
                <th class="px-4 py-3 border-b">Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Tambah Kategori</h2>
            <button onclick="toggleModal()" class="text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>
        </div>
        <form method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nama Kategori</label>
                <input type="text" name="nama" placeholder="Contoh: Elektronik"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        $(document).ready(function () {
            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('kategori.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama', name: 'nama' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
