<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'sub_kategori';

    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
