<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticketdetails extends Model
{
    public function ticket(){
        return $this->belongsTo(Ticket::class, 'tkt_id');
    }
}
