<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'first_name',
        'middle_name',
        'last_name',
        'student_id',
        'borrow_date',
        'return_date'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}