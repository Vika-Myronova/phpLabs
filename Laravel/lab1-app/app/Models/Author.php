<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{

    public $timestamps = false;

    protected $table = 'author';
    protected $fillable = [
        'name',
        'birth_year',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
