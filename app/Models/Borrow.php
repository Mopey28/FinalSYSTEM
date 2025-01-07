<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'borrow_date',
        'return_date',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
