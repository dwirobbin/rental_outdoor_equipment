<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'price',
        'stock',
        'photo',
    ];

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('price', 'LIKE', "%$searchTerm%")
            ->orWhere('stock', 'LIKE', "%$searchTerm%");
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
