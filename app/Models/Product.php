<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function childcategory()
    {
        return $this->belongsTo(ChildCategory::class);
    }

    public function productvariants()
    {
        return $this->hasMany(Productvariant::class);
    }
    public function firstVariant()
    {
        return $this->hasOne(ProductVariant::class, 'product_id');
    }

    public function productcolors()
    {
        return $this->hasMany(Productcolor::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }


}
