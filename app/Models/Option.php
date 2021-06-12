<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function foods(){
        return $this->belongsToMany(Food::class)->withPivot('price');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public  function  foodOptions(){
        return $this->hasMany(FoodOption::class);
    }

//    public function foodOptionExtras(){
//        return $this->belongsToMany(FoodOptionExtra::class,FoodOptionExtra::class);
//    }
}
