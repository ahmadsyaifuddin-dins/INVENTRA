<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use Filterable, HasFactory;

    protected $table = 'kategori'; // Definisi nama tabel manual

    protected $guarded = ['id'];   // Guard id, sisanya fillable

    // Cari berdasarkan nama atau kode
    protected $searchable = ['nama_kategori', 'kode_kategori', 'deskripsi'];

    // Relasi: Satu Kategori punya banyak Barang
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
