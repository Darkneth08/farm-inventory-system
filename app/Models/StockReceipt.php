<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReceipt extends Model
{
    protected $fillable = [
        'supplier_id',
        'received_by_user_id',
        'received_at',
        'reference_no',
        'notes',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    public function items()
    {
        return $this->hasMany(StockReceiptItem::class, 'receipt_id');
    }
}
