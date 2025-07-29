<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->dateTime('tanggal');
            $table->decimal('berat', 8, 2);
            $table->decimal('ongkos_kirim', 12, 2);
            $table->decimal('total_bayar', 15, 2);
            $table->enum('status',['dikemas','dikirim','diterima','dibatalkan'])->default('dikemas');

            $table->foreignId('pengirim_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('penerima_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->foreignId('kota_asal_id')->constrained('kotas')->onDelete('cascade');
            $table->foreignId('kota_tujuan_id')->constrained('kotas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
