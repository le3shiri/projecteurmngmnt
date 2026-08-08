<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'commission_rate',
        'phone',
        'is_active',
        'access_code',
        'cin',
        'cin_card_path',
        'cin_recto_path',
        'cin_verso_path',
        'engagement_letter_path',
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
            'commission_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupplier(): bool
    {
        return $this->role === 'supplier';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Check if user has specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return \DB::table('role_permissions')
            ->where('role', $this->role)
            ->where('permission', $permission)
            ->exists();
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class, 'agent_id');
    }

    public function supplierOrders()
    {
        return $this->hasMany(SupplierOrder::class, 'supplier_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'agent_id');
    }

    public function prospectFiles()
    {
        return $this->hasMany(ProspectFile::class, 'agent_id');
    }
}
