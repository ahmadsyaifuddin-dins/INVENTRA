<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use Filterable, HasFactory;

    protected $table = 'barang';

    // PENTING: guarded kosong artinya SEMUA kolom boleh difilter/diisi
    protected $guarded = ['id'];

    // Kolom yang bisa dicari via Search Bar (Ketik Text)
    protected $searchable = ['nama_barang', 'kode_barang', 'merek'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function penempatans()
    {
        return $this->hasMany(Penempatan::class, 'barang_id');
    }
}
