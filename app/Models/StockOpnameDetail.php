<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpnameDetail extends Model
{
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function opname()
    {
        // Ganti 'opname_id' menjadi 'stock_opname_id' jika di database menggunakan nama tersebut
        return $this->belongsTo(StockOpname::class, 'stock_opname_id');
    }
}
