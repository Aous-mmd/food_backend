<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function foods(){
        return $this->hasMany(Food::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public  function discount(){
        return $this->hasMany(Discount::class);
    }

}
