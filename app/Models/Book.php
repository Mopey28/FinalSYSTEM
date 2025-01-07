<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'genre',
        'published_year',
        'quantity',
        'status',
    ];

    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = max(0, $value);
    }
}
