<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function ticketdetails()
    {
        return $this->hasMany(Ticketdetails::class, 'tkt_id');
    }
}
