<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model {
    protected $fillable = ['name','contact_person','email','phone','address','tax_number','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function products() { return $this->hasMany(Product::class); }
    public function inventory() { return $this->hasMany(Inventory::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function stockReceipts() { return $this->hasMany(StockReceipt::class); }
}
