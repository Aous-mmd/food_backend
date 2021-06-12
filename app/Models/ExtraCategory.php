<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraCategory extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function extras(){
        return $this->hasMany(Extra::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
