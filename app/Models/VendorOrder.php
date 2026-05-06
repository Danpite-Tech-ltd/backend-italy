<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    protected $fillable = ['order_id', 'vendor_id', 'subtotal', 'delivery_charge', 'total', 'status'];

     public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function status()
    {
        return $this->belongsTo(VendorOrderStatus::class, 'vendor_order_status_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
