<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, array $filters)
    {
        // Daftar parameter sistem yang TIDAK BOLEH dianggap sebagai nama kolom
        $ignoredKeys = ['search', 'sort', 'direction', 'page', '_token'];

        // 1. LOGIC SEARCH (Global)
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $searchableFields = $this->searchable ?? [];

            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%'.$search.'%');
                }
            });
        }

        // 2. LOGIC FILTERING (Dropdown)
        foreach ($filters as $key => $value) {
            // Cek: Key bukan parameter sistem & Value tidak null
            if (! in_array($key, $ignoredKeys) && $value !== null) {
                $query->where($key, $value);
            }
        }

        // 3. LOGIC SORTING (Klik Header)
        $sortColumn = $filters['sort'] ?? 'created_at';
        $sortDirection = $filters['direction'] ?? 'desc';

        // Langsung order tanpa cek fillable (karena kita pakai guarded)
        // SQL akan throw error jika kolom tidak ada, tapi ini aman selama input dari UI terkontrol
        $query->orderBy($sortColumn, $sortDirection);
    }
}
