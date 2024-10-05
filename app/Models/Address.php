<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','name','surname','company','vat','region','city','address','cp','phone','email'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
