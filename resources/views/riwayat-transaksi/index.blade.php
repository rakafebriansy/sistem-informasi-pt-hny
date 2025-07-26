@extends('layouts.authorized')

@section('title')
    PT HNY - Dashboard
@endsection

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Riwayat Transaksi</h1>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <table id="riwayat-table" class="min-w-full">
            <thead class="bg-gray-100 text-left">
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Kode Transaksi</th>
                    <th class="px-4 py-2">Total Harga</th>
                    <th class="px-4 py-2">Keterangan</th>
                    <th class="px-4 py-2">Dibuat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-2xl">
            <h2 class="text-xl font-bold mb-4">Detail Transaksi</h2>
            <table class="w-full text-sm text-left border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Barang</th>
                        <th class="p-2 border">Jumlah</th>
                        <th class="p-2 border">Harga Satuan</th>
                        <th class="p-2 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="detail-body">
                    <!-- akan diisi via JS -->
                </tbody>
            </table>
            <div class="text-right mt-4">
                <button onclick="tutupModal()"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script>
        function lihatDetail(id) {
            $.get('/riwayat-transaksi/' + id, function(res) {
                let html = '';
                res.forEach(item => {
                    html += `
                <tr>
                    <td class="p-2 border">${item.nama_barang}</td>
                    <td class="p-2 border">${item.jumlah}</td>
                    <td class="p-2 border">Rp ${parseInt(item.harga_satuan).toLocaleString('id-ID')}</td>
                    <td class="p-2 border">Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}</td>
                </tr>`;
                });
                $('#detail-body').html(html);
                $('#modal-detail').removeClass('hidden');
            });
        }

        function tutupModal() {
            $('#modal-detail').addClass('hidden');
        }

        $(document).ready(function() {
            $('#riwayat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('riwayat-transaksi.index') }}',
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
                        data: 'total_harga',
                        name: 'total_harga',
                        searchable: false
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
                ]
            });
        });
    </script>
@endpush
