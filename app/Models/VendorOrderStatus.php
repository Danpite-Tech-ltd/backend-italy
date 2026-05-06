<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOrderStatus extends Model
{
    protected $guarded = [];

    public function vendororders()
    {
         return $this->hasMany(VendorOrder::class, 'vendor_order_status_id');
    }
}
