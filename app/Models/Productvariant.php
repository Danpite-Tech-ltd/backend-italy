<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productvariant extends Model
{

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function variant(){
        return $this->belongsTo(Variant::class);
    }

    public function productcolor(){
        return $this->belongsTo(Productcolor::class,'productcolor_id');
    }

    public function purchaseProduct()
    {
        return $this->belongsTo(PurchaseProduct::class,'productvariant_id');
    }
}
