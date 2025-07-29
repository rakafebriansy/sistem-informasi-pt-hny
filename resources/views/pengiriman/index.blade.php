@extends('layouts.authorized')

@section('title')
    PT HNY - Transaksi
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between mb-4 items-center">
            <h2 class="text-xl font-semibold">Form Transaksi Pengiriman</h2>
            <button type="button" onclick="openModalPelanggan('pengirim_id')"
                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">+ Tambah Pelanggan</button>
        </div>
        <form id="form-pengiriman" class="space-y-4">
            @csrf
            <input type="hidden" name="kode" value="{{ 'TRX-' . now()->format('YmdHis') }}">

            <div>
                <label class="block mb-1 font-medium">Pengirim</label>
                <div class="flex gap-2">
                    <select name="pengirim_id" id="pengirim_id"
                        class="flex-1 border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggans as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Penerima</label>
                <div class="flex gap-2">
                    <select name="penerima_id" id="penerima_id"
                        class="flex-1 border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggans as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Kota Asal</label>
                <select name="kota_asal_id"
                    class="w-full border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Kota --</option>
                    @foreach ($kotas as $kota)
                        <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Kota Tujuan</label>
                <select name="kota_tujuan_id"
                    class="w-full border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Kota --</option>
                    @foreach ($kotas as $kota)
                        <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Layanan</label>
                <select name="layanan_id"
                    class="w-full border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Berat (kg)</label>
                <input type="number" name="berat" step="0.01"
                    class="w-full border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-1 font-medium">Tanggal</label>
                <input type="datetime-local" name="tanggal"
                    class="w-full border-gray-300 border rounded px-2 py-1 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div id="modalPelanggan" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-semibold mb-4">Tambah Pelanggan</h2>
            <form id="form-tambah-pelanggan" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1 font-medium">Nama Pelanggan</label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Alamat</label>
                    <input type="text" name="alamat" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Nomor Telepon</label>
                    <input type="text" name="no_hp" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="tutupModalPelanggan()"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let dropdownTarget = '';

        function openModalPelanggan(dropdownId) {
            dropdownTarget = dropdownId;
            $('#modalPelanggan').removeClass('hidden');
        }

        function tutupModalPelanggan() {
            $('#modalPelanggan').addClass('hidden');
            $('#form-tambah-pelanggan')[0].reset();
        }

        $('#form-tambah-pelanggan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('pelanggan.store') }}", // pastikan route pelanggan.store sudah ada
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    // Tambahkan ke dropdown
                    const option = new Option(res.nama, res.id, true, true);
                    $('#' + dropdownTarget).append(option).trigger('change');
                    tutupModalPelanggan();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pelanggan baru ditambahkan dan dipilih.'
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let pesan = '';
                    for (let key in errors) {
                        pesan += errors[key][0] + '\n';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menambah Pelanggan',
                        text: pesan
                    });
                }
            });
        });

        $('#form-pengiriman').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('pengiriman.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Transaksi pengiriman berhasil disimpan'
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let pesan = '';
                    for (let key in errors) {
                        pesan += errors[key][0] + '\n';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: pesan
                    });
                }
            });
        });
    </script>
@endpush
