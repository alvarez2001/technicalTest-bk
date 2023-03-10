<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'reference', 'category', 'price', 'weight', 'stock'
    ];

    protected $casts = [
        'price'  =>  'integer',
        'weight'  =>  'integer',
        'stock'  =>  'integer',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
