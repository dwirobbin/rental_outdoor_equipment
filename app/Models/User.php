<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'ordered_by', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function scopeSearch($query, string $searchTerm)
    {
        return $query
            ->where('users.name', 'LIKE', "%$searchTerm%")
            ->orWhere('users.username', 'LIKE', "%$searchTerm%")
            ->orWhere('users.email', 'LIKE', "%$searchTerm%")
            ->orWhere('roles.name', 'LIKE', "%$searchTerm%");
    }
}
