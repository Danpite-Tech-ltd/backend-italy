<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    protected $fillable = ['order_id', 'vendor_id', 'subtotal', 'delivery_charge', 'total', 'status'];
}
