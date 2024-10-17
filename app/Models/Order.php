<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','total','status','delivered_at'];
    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'order_products' )->withPivot('quantity', 'price')->withTimestamps();
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

}
