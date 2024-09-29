<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\search;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'quantity', 'seller_id', 'category_id', 'image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function carts(){
        return $this->belongsToMany(Cart::class, 'cart_products' )->withPivot('quantity', 'price')->withTimestamps();
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_products' )->withPivot('quantity', 'price')->withTimestamps();
    }

    public function scopeFilterAdvancedProduct($query,$search,$category_id){
        if($search){
            $query->where("name","like","%".$search."%");
        }

        if($category_id){
            $query->where("category_id",$category_id);
        }

        return $query;
    }
}
