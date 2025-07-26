@extends('layouts.authorized')

@section('title')
    PT HNY - Transaksi
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Transaksi</h1>

        <!-- Form Tambah Barang ke Keranjang -->
        <div class="bg-white p-4 shadow rounded mb-4">
            <h2 class="text-xl font-semibold mb-2">Tambah Barang</h2>
            <form id="form-tambah-barang">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="barang_id" class="block text-sm font-medium">Pilih Barang</label>
                        <select id="barang_id" class="w-full border rounded p-2">
                            <option value="">-- Pilih --</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}">{{ $barang->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium">Jumlah</label>
                        <input type="number" id="jumlah" class="w-full border rounded p-2" min="1"
                            value="1">
                    </div>
                </div>
                <button type="submit" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
            </form>
        </div>

        <!-- Daftar Keranjang -->
        <div class="bg-white p-4 shadow rounded mb-4">
            <h2 class="text-xl font-semibold mb-2">Keranjang</h2>
            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Barang</th>
                        <th class="p-2 border">Jumlah</th>
                        <th class="p-2 border">Harga</th>
                        <th class="p-2 border">Subtotal</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="keranjang-body"></tbody>
            </table>
            <div class="mt-3 text-right font-bold text-lg">
                Total: Rp <span id="total-harga">0</span>
            </div>
        </div>

        <!-- Simpan Transaksi -->
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-xl font-semibold mb-2">Simpan Transaksi</h2>
            <form method="POST" action="{{ route('transaksi.store') }}">
                @csrf
                <input type="hidden" name="keranjang" id="keranjang-json">
                <div class="mb-3">
                    <label class="block text-sm">Keterangan (Opsional)</label>
                    <textarea name="keterangan" class="w-full border rounded p-2"></textarea>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan Transaksi</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let keranjang = [];

        $('#form-tambah-barang').submit(function(e) {
            e.preventDefault();
            const id = $('#barang_id').val();
            const nama = $('#barang_id option:selected').text();
            const harga = parseFloat($('#barang_id option:selected').data('harga'));
            const jumlah = parseInt($('#jumlah').val());

            if (!id || jumlah <= 0) return alert("Lengkapi data");

            const subtotal = harga * jumlah;
            keranjang.push({
                id,
                nama,
                harga,
                jumlah,
                subtotal
            });
            renderKeranjang();
        });

        function renderKeranjang() {
            let html = '';
            let total = 0;
            keranjang.forEach((item, index) => {
                total += item.subtotal;
                html += `
                <tr>
                    <td class="border p-2">${item.nama}</td>
                    <td class="border p-2">${item.jumlah}</td>
                    <td class="border p-2">Rp ${item.harga.toLocaleString()}</td>
                    <td class="border p-2">Rp ${item.subtotal.toLocaleString()}</td>
                    <td class="border p-2">
                        <button onclick="hapusItem(${index})" class="text-red-600">Hapus</button>
                    </td>
                </tr>`;
            });
            $('#keranjang-body').html(html);
            $('#total-harga').text(total.toLocaleString());
            $('#keranjang-json').val(JSON.stringify(keranjang));
        }

        function hapusItem(index) {
            keranjang.splice(index, 1);
            renderKeranjang();
        }
    </script>
@endpush
