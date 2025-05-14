<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'phone',
        'address',
        'email',
        'password',
        'is_active',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include users with a specific role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Check if user has the admin role
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has the saler role
     *
     * @return bool
     */
    public function isSaler(): bool
    {
        return $this->role === 'saler';
    }

    /**
     * Check if user has the user role
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    
    /**
     * Check if user has the content role
     *
     * @return bool
     */
    public function isContent(): bool
    {
        return $this->role === 'content';
    }

    /**
     * Check if user has the specified role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get the invoices for the user.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
