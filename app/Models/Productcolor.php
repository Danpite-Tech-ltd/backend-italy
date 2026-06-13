<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productcolor extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function productvariants()
    {
        return $this->hasMany(Productvariant::class, 'productcolor_id', 'id');
    }
}
