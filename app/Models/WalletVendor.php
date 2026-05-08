<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletVendor extends Model
{
    protected $fillable = [
        'vendor_id',
        'type',
        'amount',
        'balance',
        'bank_id',
        'status',
        'note',
        'admin_note'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
