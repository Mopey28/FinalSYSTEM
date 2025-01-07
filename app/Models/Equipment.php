<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'quantity',
        'brand_model',
        'engine_serial_no',
        'inventory_tag_no',
        'purchased_by',
        'remarks',
        'status',
    ];

    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = max(0, $value);
    }
}
