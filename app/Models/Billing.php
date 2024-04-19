<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory;

    protected $table = 'billings';

    protected $fillable = [
        'order_id',
        'created_date',
        'due_date',
        'total',
        'image',
        'status',
    ];

    protected $casts = [
        'created_date' => 'date:d M Y',
        'due_date' => 'date:d M Y',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('orders.order_code', 'LIKE', "%$searchTerm%")
            ->orWhere('users.name', 'LIKE', "%$searchTerm%")
            ->orWhere('billings.total', 'LIKE', "%$searchTerm%")
            ->orWhere('billings.created_date', 'LIKE', "%$searchTerm%")
            ->orWhere('billings.due_date', 'LIKE', "%$searchTerm%")
            ->orWhere('billings.status', 'LIKE', "%$searchTerm%");
    }
}
