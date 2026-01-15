<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    use Filterable, HasFactory;

    protected $table = 'ruangan';

    protected $guarded = ['id'];

    protected $searchable = ['nama_ruangan', 'penanggung_jawab'];

    // Relasi: Satu Ruangan punya banyak Penempatan
    public function penempatans(): HasMany
    {
        return $this->hasMany(Penempatan::class, 'ruangan_id');
    }
}
