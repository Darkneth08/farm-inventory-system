<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $fillable = [
        'name','sku','barcode','description','category_id','supplier_id',
        'unit_price','unit_of_measure','current_stock','min_stock_level',
        'max_stock_level','reorder_point','image','is_active'
    ];
    protected $casts = ['is_active'=>'boolean','unit_price'=>'decimal:2'];
    public function category() { return $this->belongsTo(Category::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function inventory() { return $this->hasMany(Inventory::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function customerRequests() { return $this->hasMany(CustomerRequest::class); }
    public function saleItems() { return $this->hasMany(SaleItem::class); }
    public function stockReceiptItems() { return $this->hasMany(StockReceiptItem::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function reviews() { return $this->hasMany(ProductReview::class); }
    public function favoritedByUsers() {
        return $this->belongsToMany(User::class, 'favorite_products', 'product_id', 'user_id')
            ->withTimestamps();
    }
    public function getStockStatusAttribute() {
        if ($this->current_stock <= 0) return 'Out of Stock';
        if ($this->current_stock <= $this->reorder_point) return 'Low Stock';
        return 'In Stock';
    }
}
