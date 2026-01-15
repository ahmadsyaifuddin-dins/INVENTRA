<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Filterable, HasFactory, Notifiable;

    /**
     * Karena nama tabel di database adalah 'pengguna'
     */
    protected $table = 'pengguna';

    // Kolom yang bisa dicari
    protected $searchable = ['nama_lengkap', 'username', 'role'];

    /**
     * Kita guard ID saja, sisanya boleh diisi massal
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
