<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_code',
        'ordered_by',
        'start_date',
        'end_date',
        'image',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function orderedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ordered_by', 'id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'order_id', 'id');
    }

    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class, 'order_id', 'id');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('users.name', 'LIKE', "%$searchTerm%")
            ->orWhere('order_details.amount', 'LIKE', "%$searchTerm%")
            ->orWhere('orders.order_code', 'LIKE', "%$searchTerm%")
            ->orWhere('orders.start_date', 'LIKE', "%$searchTerm%")
            ->orWhere('orders.end_date', 'LIKE', "%$searchTerm%")
            ->orWhere('orders.status', 'LIKE', "%$searchTerm%");
    }
}
