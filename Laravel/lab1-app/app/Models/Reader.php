<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reader extends BaseModel
{
    public $timestamps = false;
    protected $table = 'reader';
    protected $fillable = [
        'full_name',
        'email',
    ];

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['full_name'])) {
            $query->where('full_name', 'like', '%' . $filters['full_name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }
    }
}
