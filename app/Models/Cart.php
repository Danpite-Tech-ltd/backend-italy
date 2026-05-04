<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $guarded = [];

    // Relationships (optional, if you have related models)
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function productcolor()
    {
        return $this->belongsTo(Productcolor::class, 'color_id');
    }

    public function productvariant()
    {
        return $this->belongsTo(Productvariant::class, 'variant_id');
    }
}
