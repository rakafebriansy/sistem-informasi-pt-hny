@extends('layouts.authorized')

@section('title')
    PT HNY - Riwayat Pengiriman
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Riwayat Pengiriman</h1>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
        <table id="pengiriman-table" class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
                    <th class="px-4 py-3 border-b">Kode</th>
                    <th class="px-4 py-3 border-b">Tanggal</th>
                    <th class="px-4 py-3 border-b">Status</th>
                    <th class="px-4 py-3 border-b">Kota Asal</th>
                    <th class="px-4 py-3 border-b">Kota Tujuan</th>
                    <th class="px-4 py-3 border-b">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Detail Pengiriman</h2>
                <button onclick="toggleDetailModal()" class="text-gray-500 hover:text-gray-700 text-lg">&times;</button>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="font-semibold">Kode:</label>
                    <p id="detail-kode" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Tanggal:</label>
                    <p id="detail-tanggal" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Berat (kg):</label>
                    <p id="detail-berat" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Ongkos Kirim:</label>
                    <p id="detail-ongkir" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Total Bayar:</label>
                    <p id="detail-total_bayar" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Status:</label>
                    <p id="detail-status" class="text-gray-700 capitalize"></p>
                </div>
                <div>
                    <label class="font-semibold">Pengirim ID:</label>
                    <p id="detail-pengirim_id" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Penerima ID:</label>
                    <p id="detail-penerima_id" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Layanan ID:</label>
                    <p id="detail-layanan_id" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Kota Asal ID:</label>
                    <p id="detail-kota_asal_id" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">Kota Tujuan ID:</label>
                    <p id="detail-kota_tujuan_id" class="text-gray-700"></p>
                </div>
                <div>
                    <label class="font-semibold">User ID:</label>
                    <p id="detail-user_id" class="text-gray-700"></p>
                </div>
            </div>
            <div class="mt-6 text-right">
                <button onclick="toggleDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script>
        function toggleDetailModal() {
            document.getElementById('detailModal').classList.toggle('hidden');
            document.getElementById('detailModal').classList.toggle('flex');
        }

        function fetchDetail(id) {
            $.ajax({
                url: `/pengiriman/${id}`,
                type: 'GET',
                success: function(data) {
                    document.getElementById('detail-kode').textContent = data.kode;
                    document.getElementById('detail-tanggal').textContent = data.tanggal;
                    document.getElementById('detail-berat').textContent = data.berat;
                    document.getElementById('detail-ongkir').textContent = 'Rp ' + parseFloat(data.ongkir)
                        .toLocaleString();
                    document.getElementById('detail-total_bayar').textContent = 'Rp ' + parseFloat(data
                        .total_bayar).toLocaleString();
                    document.getElementById('detail-status').textContent = data.status;
                    document.getElementById('detail-pengirim_id').textContent = data.pengirim_id;
                    document.getElementById('detail-penerima_id').textContent = data.penerima_id;
                    document.getElementById('detail-layanan_id').textContent = data.layanan_id;
                    document.getElementById('detail-kota_asal_id').textContent = data.kota_asal_id;
                    document.getElementById('detail-kota_tujuan_id').textContent = data.kota_tujuan_id;
                    document.getElementById('detail-user_id').textContent = data.user_id;

                    toggleDetailModal();
                },
                error: function(xhr) {
                    alert("Gagal memuat detail pengiriman");
                }
            });
        }


        $(document).ready(function() {
            $('#pengiriman-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('riwayat-pengiriman.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false
                    },
                    {
                        data: 'kota_asal',
                        name: 'kota_asal'
                    },
                    {
                        data: 'kota_tujuan',
                        name: 'kota_tujuan'
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
