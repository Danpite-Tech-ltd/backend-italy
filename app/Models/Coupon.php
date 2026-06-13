<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //

    public function isValid()
    {
        $currentDate = now();

        return $this->status === 1 && $currentDate->between($this->active_date, $this->expire_date);
    }
}
