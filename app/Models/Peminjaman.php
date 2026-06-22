<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use Filterable, HasFactory;

    protected $table = 'peminjaman';

    protected $guarded = ['id'];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // Relasi ke Pengguna (Peminjam)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
