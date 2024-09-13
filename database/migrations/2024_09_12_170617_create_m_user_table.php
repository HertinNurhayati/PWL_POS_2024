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
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id'); // Primary key
            $table->unsignedBigInteger('level_id'); // Foreign key ke level_id
            $table->string('username', 20)->unique(); // Unique username
            $table->string('nama', 100); // Nama pengguna
            $table->string('password', 255); // Password pengguna
            $table->timestamps(); // Created_at dan Updated_at

            // Menambahkan foreign key constraint
            $table->foreign('level_id')->references('level_id')->on('m_level')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            // Menghapus foreign key constraint sebelum menghapus tabel
            $table->dropForeign(['level_id']);
        });

        Schema::dropIfExists('m_user');
    }
};
