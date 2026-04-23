<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model {
    protected $fillable = [
        'transaction_number','product_id','inventory_id','transaction_type',
        'quantity','unit_price','total_amount','warehouse_id','user_id',
        'supplier_id','reference_number','sale_id','notes'
    ];
    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
    public function product() { return $this->belongsTo(Product::class); }
    public function inventory() { return $this->belongsTo(Inventory::class); }
    public function warehouse() { return $this->belongsTo(Warehouse::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function sale() { return $this->belongsTo(Sale::class); }
}
