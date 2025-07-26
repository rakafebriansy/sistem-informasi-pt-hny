@extends('layouts.authorized')

@section('title')
    PT HNY - Dashboard
@endsection

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Kelola Barang</h1>
        <button onclick="toggleModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah
            Barang</button>
    </div>

    <!-- DataTable -->
    <div class="bg-white p-4 rounded shadow">
        <table id="barang-table" class="min-w-full">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Tambah Barang</h2>
            <form method="POST" action="{{ route('barang.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm">Kode Barang</label>
                    <input type="text" placeholder="Masukkan nama barang" name="kode_barang"
                        class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Nama Barang</label>
                    <input type="text" placeholder="Masukkan nama barang" name="nama_barang"
                        class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Kategori</label>
                    <select name="kategori_id" class="w-full border rounded px-2 py-1">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Satuan</label>
                    <input type="text" placeholder="Masukkan nama satuan" name="satuan"
                        class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Harga Jual</label>
                    <input type="number" placeholder="Masukkan harga jual" name="harga_jual"
                        class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Harga Beli</label>
                    <input type="number" placeholder="Masukkan harga beli" name="harga_beli"
                        class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Stok</label>
                    <input type="number" placeholder="Masukkan jumlah stok" name="stok"
                        class="w-full border rounded px-2 py-1" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="toggleModal()" class="mr-2 px-4 py-2 rounded bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script>
        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden');
            document.getElementById('modal').classList.toggle('flex');
        }

        $(document).ready(function() {
            $('#barang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('barang.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'kategori_nama',
                        name: 'kategori_nama'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data yang tersedia",
                    zeroRecords: "Data tidak ditemukan",
                    processing: "Memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                }
            });
        });
    </script>
@endpush
