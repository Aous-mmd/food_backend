<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['image:imageable_id,image_path'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function options(){
        return $this->belongsToMany(Option::class)->withPivot('price');
    }

    public  function  foodOptions(){
        return $this->hasMany(FoodOption::class);
    }
    public  function  foodOption(){
        return $this->hasOne(FoodOption::class)->oldest();
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
