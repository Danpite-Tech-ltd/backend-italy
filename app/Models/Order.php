<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }



    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }


    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function invoiceGenerator()
    {
        // Get the last product (or null if none exists)
        $lastOrder = Order::latest()->first();
        $prefix      = BasicInfo::first()->order_invoice_prefix;

        // Generate numeric part
        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;


        // Return prefix + padded number
        return $prefix . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }


}
