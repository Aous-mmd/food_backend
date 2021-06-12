<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOptionExtra extends Model
{
    protected $table ='food_option_extras';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function extra(){
        return $this->belongsTo(Extra::class);
    }
    public function food_option(){
        return $this->belongsTo(FoodOption::class);
    }
}
