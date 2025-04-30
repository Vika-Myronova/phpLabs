<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends BaseModel
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
}
