@extends('layouts.authorized')

@section('title')
    PT HNY - Transaksi
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <form id="form-pengiriman">
            @csrf
            <input type="hidden" name="kode" value="{{ 'TRX-' . now()->format('YmdHis') }}">

            <label>Pengirim</label>
            <select name="pengirim_id" class="form-input">
                @foreach ($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>

            <label>Penerima</label>
            <select name="penerima_id" class="form-input">
                @foreach ($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>

            <label>Kota Asal</label>
            <select name="kota_asal_id" class="form-input">
                @foreach ($kotas as $kota)
                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                @endforeach
            </select>

            <label>Kota Tujuan</label>
            <select name="kota_tujuan_id" class="form-input">
                @foreach ($kotas as $kota)
                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                @endforeach
            </select>

            <label>Layanan</label>
            <select name="layanan_id" class="form-input">
                @foreach ($layanans as $layanan)
                    <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                @endforeach
            </select>

            <label>Berat (kg)</label>
            <input type="number" name="berat" step="0.01" class="form-input">

            <label>Tanggal</label>
            <input type="datetime-local" name="tanggal" class="form-input">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Simpan</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
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
