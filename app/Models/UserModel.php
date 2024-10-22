<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id'; // Penulisan "primaryKey" harus dengan huruf besar "K"
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'avatar', 'created_at', 'updated_at'];

    protected $hidden = ['password']; // Jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed']; // Casting password agar otomatis di-hash

    /**
     * Relasi ke tabel level
     *
     * @return BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * Mendapatkan nama role
     *
     * @return string
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->level->level_kode == $role;
    }

    /**
     * * Mendapatkan kode role
    */
    public function getRole()
    {
        return $this->level->level_kode;
    }
}
    