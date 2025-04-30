<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public $timestamps = false;
    protected $table = 'book';

    protected $fillable = [
        'title',
        'published_year',
        'isbn',
        'author_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class,'author_id');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['published_year'])) {
            $query->where('published_year', $filters['published_year']);
        }

        if (!empty($filters['isbn'])) {
            $query->where('isbn', 'like', '%' . $filters['isbn'] . '%');
        }

        if (!empty($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }
    }

}
