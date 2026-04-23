<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReceiptItem extends Model
{
    protected $fillable = [
        'receipt_id',
        'product_id',
        'batch_number',
        'manufacturing_date',
        'expiry_date',
        'quantity',
        'unit_cost',
        'line_total',
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiry_date' => 'date',
        'unit_cost' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function receipt()
    {
        return $this->belongsTo(StockReceipt::class, 'receipt_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
