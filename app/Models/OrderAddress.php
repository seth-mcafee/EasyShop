<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','name','surname','company','vat','region','city','address','cp','phone','email'];

    public function order(){
        return $this->hasOne(Order::class);
    }
}
