<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = array('pivot' ,'created_at', 'updated_at');


    public function extra_category(){
        return $this->belongsTo(ExtraCategory::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function food_options(){
        return $this->belongsToMany(FoodOption::class);
    }

    public function order_details(){
        return $this->belongsToMany(OrderDetail::class)->withPivot('price','quantity');
    }

    public function food_options_extra(){
        return $this->hasMany(FoodOption::class);
    }
}
