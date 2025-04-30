<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Category extends BaseModel
{
    public $timestamps = false;
    protected $table = 'category';

    protected $fillable = [
        'name',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category', 'category_id', 'book_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query;
    }
}
