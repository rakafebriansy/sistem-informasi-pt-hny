@extends('layouts.authorized')

@section('title')
    PT HNY - Kategori
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Kelola Kategori</h1>
        <button onclick="toggleModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
            + Tambah Kategori
        </button>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
        <table id="kategori-table" class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
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
            <form id="form-tambah">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" id="tambah-nama" placeholder="Masukkan nama kategori"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="toggleModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Edit Kategori</h2>
                <button onclick="toggleEditModal()"
                    class="text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>
            </div>
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" id="edit-nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="toggleEditModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function deleteKategori(id) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: `/kategori/${id}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            $('#kategori-table').DataTable().ajax.reload();
                            Swal.fire('Berhasil!', 'Kategori dihapus.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        }

        function toggleEditModal() {
            const modal = document.getElementById('modal-edit');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function openEditModal(id, nama) {
            toggleEditModal();
            document.getElementById('edit-nama').value = nama;
            const form = document.getElementById('form-edit');
            form.action = `/kategori/${id}`;
        }

        $('#form-tambah').on('submit', function(e) {
            e.preventDefault();
            let nama = $('#tambah-nama').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('kategori.store') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    nama: nama
                },
                success: function(response) {
                    toggleModal();
                    $('#kategori-table').DataTable().ajax.reload();
                    Swal.fire('Berhasil!', 'Kategori ditambahkan.', 'success');
                    $('#form-tambah')[0].reset();
                },
                error: function(xhr) {
                    let error = xhr.responseJSON?.errors?.nama?.[0] || 'Terjadi kesalahan.';
                    Swal.fire('Gagal', error, 'error');
                }
            });
        });

        $('#form-edit').on('submit', function(e) {
            e.preventDefault();
            let nama = $('#edit-nama').val();
            let url = this.action;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    nama: nama
                },
                success: function(response) {
                    toggleEditModal();
                    $('#kategori-table').DataTable().ajax.reload();
                    Swal.fire('Berhasil!', 'Kategori diupdate.', 'success');
                },
                error: function(xhr) {
                    let error = xhr.responseJSON?.errors?.nama?.[0] || 'Terjadi kesalahan.';
                    Swal.fire('Gagal', error, 'error');
                }
            });
        });

        $(document).ready(function() {
            $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('kategori.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
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
