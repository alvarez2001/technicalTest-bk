<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'quantity', 'unit_price', 'total_price'
    ];

    protected $casts = [
        'quantity'  =>  'integer',
        'unit_price'  =>  'integer',
        'total_price'  =>  'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
