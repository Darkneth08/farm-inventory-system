<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'role_id',
        'status',
        'phone',
        'address',
        'permissions_override',
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
            'permissions_override' => 'array',
        ];
    }

    public function hasRole(string ...$roles): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        return in_array($this->role, $roles, true);
    }

    public function customerRequests()
    {
        return $this->hasMany(CustomerRequest::class);
    }

    public function roleInfo()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function stockReceiptsReceived()
    {
        return $this->hasMany(StockReceipt::class, 'received_by_user_id');
    }

    public function salesAsCustomer()
    {
        return $this->hasMany(Sale::class, 'customer_user_id');
    }

    public function salesAsCashier()
    {
        return $this->hasMany(Sale::class, 'cashier_user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_user_id');
    }

    public function processedOrders()
    {
        return $this->hasMany(Order::class, 'processed_by_user_id');
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorite_products', 'user_id', 'product_id')
            ->withTimestamps();
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function promotionsCreated()
    {
        return $this->hasMany(Promotion::class, 'created_by_user_id');
    }

    public function loginActivities()
    {
        return $this->hasMany(LoginActivity::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function updatedSystemSettings()
    {
        return $this->hasMany(SystemSetting::class, 'updated_by_user_id');
    }

}
