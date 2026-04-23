<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inventory extends Model {
    protected $table = 'inventory';
    protected $fillable = [
        'product_id','warehouse_id','batch_number','quantity','unit_cost',
        'selling_price','expiry_date','manufacturing_date','supplier_id',
        'location_in_warehouse','status','notes'
    ];
    protected $casts = [
        'expiry_date'=>'date',
        'manufacturing_date'=>'date',
        'unit_cost'=>'decimal:2',
        'selling_price'=>'decimal:2'
    ];
    public function product() { return $this->belongsTo(Product::class); }
    public function warehouse() { return $this->belongsTo(Warehouse::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}
