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
}
