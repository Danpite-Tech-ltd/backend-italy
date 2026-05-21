<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id')->select('id', 'name', 'slug', 'thumbnail_img');
    }

}
