<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'name',
        'number',
        'photo',
    ];

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('number', 'LIKE', "%$searchTerm%");
    }
}
