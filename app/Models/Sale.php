<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_number',
        'customer_user_id',
        'cashier_user_id',
        'sold_at',
        'subtotal',
        'discount',
        'discount_type',
        'discount_id_number',
        'discount_id_image_path',
        'total',
        'amount_paid',
        'change_due',
        'payment_method',
        'gcash_reference_number',
        'gcash_receipt_image_path',
        'notes',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_due' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_user_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
