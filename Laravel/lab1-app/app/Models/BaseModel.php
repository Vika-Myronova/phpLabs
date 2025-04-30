<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }
        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @param int $itemsPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePaginateWithFilters($query, array $filters, $itemsPerPage = 10)
    {
        return $this->scopeFilter($query, $filters)->paginate($itemsPerPage);
    }

}
