@extends('layouts.authorized')

@section('title')
    PT HNY - Transaksi
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between mb-4 items-center">
            <h2 class="text-xl font-semibold">Form Transaksi Pengiriman</h2>
            <button type="button" onclick="openModalPelanggan()"
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
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2" placeholder="Masukkan nama"
                        required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Alamat</label>
                    <input type="text" name="alamat" class="w-full border rounded px-3 py-2"
                        placeholder="Masukkan alamat" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Nomor Telepon</label>
                    <input type="text" name="no_hp" class="w-full border rounded px-3 py-2"
                        placeholder="Masukkan nomor telepon" required>
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
        function openModalPelanggan() {
            $('#modalPelanggan').removeClass('hidden');
        }

        function tutupModalPelanggan() {
            $('#modalPelanggan').addClass('hidden');
            $('#form-tambah-pelanggan')[0].reset();
        }

        $('#form-tambah-pelanggan').submit(function(e) {
            e.preventDefault();

            const submitBtn = $(this).find('button[type="submit"]');

            submitBtn.prop('disabled', true).html(`
                <svg class="animate-spin h-4 w-4 mr-2 inline-block text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                    </path>
                </svg> Menyimpan...
            `);

            $.ajax({
                url: "{{ route('pelanggan.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    const option1 = new Option(res.nama, res.id, false, false);
                    const option2 = new Option(res.nama, res.id, false, false);

                    $('#pengirim_id').append(option1);
                    $('#penerima_id').append(option2);

                    tutupModalPelanggan();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pelanggan baru ditambahkan.'
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
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html('Simpan');
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
                    console.log(res);
                    console.log(res.data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Transaksi pengiriman berhasil disimpan'
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(xhr);
                    let pesan = '';
                    for (let key in errors) {
                        pesan += errors[key][0] + '\n';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Pencatatan Pengiriman Gagal',
                        text: pesan
                    });
                }
            });
        });
    </script>
@endpush
