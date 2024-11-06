<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

// class UserModel extends Model
class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //Mendefiniskan primary key dari tabel yang digunakan
    protected $fillable = ['username','password','nama','level_id','avatar','created_at', 'updated_at'];
    
    // protected $hidden = ['password']; // jangan di tampilkan saat select
    
    protected $casts=  ['password'=> 'hashed']; // casting password agar otomatis di hash
    
    // protected $fillable = ['level_id', 'username', 'nama'];
    public function level(): BelongsTo 
    { 
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function profil(): HasOne
    {
        return $this->hasOne(ProfilUserModel::class, 'user_id', 'user_id');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}