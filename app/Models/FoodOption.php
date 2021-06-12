<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   FoodOption extends Model
{
    protected $table = 'food_option';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    //protected $with = ['option','food'];
    protected $hidden = ['created_at', 'updated_at'];

    public function order_detail(){
        return $this->hasMany(OrderDetail::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function extras(){
        return $this->belongsToMany(Extra::class,FoodOptionExtra::class);
    }

    public function foodOptionExtra(){
        return $this->hasMany(FoodOptionExtra::class);
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }

    public function food(){
        return $this->belongsTo(Food::class);
    }
}
