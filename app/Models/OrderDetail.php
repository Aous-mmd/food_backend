<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden =['created_at', 'updated_at'];
    protected $with =['food_option'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function food_option(){
        return $this->belongsTo(FoodOption::class);
    }
    public function extras(){
        return $this->belongsToMany(Extra::class,OrderDetailExtra::class)->withPivot('price','quantity');
    }
    public function order_details_extra(){
        return $this->hasMany(OrderDetailExtra::class,'order_detail_id','id');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function (OrderDetail $orderDetail){
           $orderDetail->order_details_extra()->delete();
        });

    }
}
