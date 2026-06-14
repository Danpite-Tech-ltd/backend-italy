<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //

    public function isValid()
    {
        $currentDate = now();

        return $this->status == 1
            && $currentDate->between(
                \Carbon\Carbon::parse($this->active_date),
                \Carbon\Carbon::parse($this->expire_date)
            );
    }
}
