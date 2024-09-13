<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id'); // Primary key
            $table->unsignedBigInteger('supplier_id')->index(); // Foreign key ke tabel supplier
            $table->unsignedBigInteger('barang_id')->index();   // Foreign key ke tabel barang
            $table->unsignedBigInteger('user_id')->index();     // Foreign key ke tabel user
            $table->dateTime('stok_tanggal'); // Tanggal stok dalam format datetime
            $table->integer('stok_jumlah');   // Jumlah stok dengan tipe integer
            $table->timestamps(); // Created_at dan Updated_at

            // Menambahkan foreign key constraints
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stok'); // Menghapus tabel jika rollback
    }
};
