@extends('layouts.authorized')

@section('title')
    PT HNY - Layanan
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Kelola Layanan</h1>
        <button onclick="toggleCreateModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
            + Tambah Layanan
        </button>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
        <table id="layanan-table" class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
                    <th class="px-4 py-3 border-b">Nama</th>
                    <th class="px-4 py-3 border-b">Estimasi Hari</th>
                    <th class="px-4 py-3 border-b">Tarif per Kg</th>
                    <th class="px-4 py-3 border-b">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Layanan</h2>
                <button onclick="toggleCreateModal()"
                    class="text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>
            </div>
            <form id="form-tambah">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Nama Layanan</label>
                    <input type="text" name="nama" id="tambah-nama" placeholder="Masukkan nama kota"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Estimasi Hari</label>
                    <input type="number" name="estimasi_hari" id="tambah-estimasi-hari"
                        placeholder="Masukkan estimasi hari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Tarif per Kg</label>
                    <input type="number" name="tarif_per_kg" id="tambah-tarif-per-kg" placeholder="Masukkan tarif per kg"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="toggleCreateModal()"
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
                <h2 class="text-xl font-semibold text-gray-800">Edit Layanan</h2>
                <button onclick="toggleEditModal()"
                    class="text-gray-400 hover:text-red-500 text-xl font-bold">&times;</button>
            </div>
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Nama Layanan</label>
                    <input type="text" name="nama" id="edit-nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Estimasi Hari</label>
                    <input type="number" name="estimasi_hari" id="edit-estimasi-hari"
                        placeholder="Masukkan estimasi hari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Tarif per Kg</label>
                    <input type="number" name="tarif_per_kg" id="edit-tarif-per-kg" placeholder="Masukkan tarif per kg"
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
        function toggleCreateModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function toggleEditModal() {
            const modal = document.getElementById('modal-edit');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function editLayanan(id) {
            $.get(`/layanan/${id}`, function(data) {
                $('#edit-id').val(data.id);
                $('#edit-nama').val(data.nama);
                $('#edit-estimasi-hari').val(data.estimasi_hari);
                $('#edit-tarif-per-kg').val(data.tarif_per_kg);
                $('#form-edit').attr('action', `/layanan/${id}`);
                toggleEditModal();
            });
        }

        $('#form-tambah').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('layanan.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#layanan-table').DataTable().ajax.reload();
                    toggleCreateModal();
                    $('#form-tambah')[0].reset();

                    Swal.fire('Berhasil!', 'Layanan berhasil ditambahkan.', 'success');
                },
                error: function(xhr) {
                    let msg = 'Gagal menambahkan layanan.';
                    if (xhr.status === 422) {
                        const errors = Object.values(xhr.responseJSON.errors)
                            .map(arr => arr.join(', '))
                            .join('<br>');
                        msg = errors;
                    }

                    Swal.fire('Gagal', msg, 'error');
                }
            });
        });


        $('#form-edit').on('submit', function(e) {
            e.preventDefault();
            var action = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                url: action,
                type: 'POST',
                data: formData,
                success: function() {
                    toggleEditModal();
                    $('#layanan-table').DataTable().ajax.reload();
                    Swal.fire('Berhasil', 'Layanan berhasil diperbarui.', 'success');
                },
                error: function() {
                    Swal.fire('Gagal', 'Gagal menyimpan perubahan.', 'error');
                }
            });
        });

        function deleteLayanan(id) {
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
                        url: `/layanan/${id}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            $('#layanan-table').DataTable().ajax.reload();
                            Swal.fire('Berhasil!', 'Layanan dihapus.', 'success');
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#layanan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('layanan.index') }}',
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
                        data: 'estimasi_hari',
                        name: 'estimasi_hari'
                    },
                    {
                        data: 'tarif_per_kg',
                        name: 'tarif_per_kg'
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
