<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class);
    }
}
