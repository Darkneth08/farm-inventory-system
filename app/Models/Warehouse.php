<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Warehouse extends Model {
    protected $fillable = ['branch_id','name','code','location','manager_name','phone','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function branch() { return $this->belongsTo(Branch::class); }
    public function inventory() { return $this->hasMany(Inventory::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}
