<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateWithdraw extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'affiliate_id');
    }
}
