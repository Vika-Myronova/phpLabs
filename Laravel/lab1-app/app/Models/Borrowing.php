<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Borrowing extends Model
{
    public $timestamps = false;
    protected $table = 'borrowing';

    protected $fillable = [
        'borrow_date',
        'return_date',
        'book_id',
        'reader_id',
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['borrow_date'])) {
            $query->whereDate('borrow_date', $filters['borrow_date']);
        }

        if (!empty($filters['return_date'])) {
            $query->whereDate('return_date', $filters['return_date']);
        }

        if (!empty($filters['book_id'])) {
            $query->where('book_id', $filters['book_id']);
        }

        if (!empty($filters['reader_id'])) {
            $query->where('reader_id', $filters['reader_id']);
        }

        return $query;
    }

}
