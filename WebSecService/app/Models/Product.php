<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model  {

    protected $fillable = [
        'code',
        'name',
        'model',
        'description',
        'price',
        'quantity',
        'photo'
    ];

    protected $appends = ['stock_status'];
    
    public function getStockStatusAttribute()
    {
        return $this->quantity > 0 ? 'In Stock' : 'Out of Stock';
    }

}