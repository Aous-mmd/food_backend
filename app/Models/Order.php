<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //TODO save total price as decimal
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'id' => 'integer',
        'total_price' => 'string'];
    protected $hidden = ['created_at', 'updated_at'];

//    public function user(){
//        return $this->belongsTo(User::class);
//    }

    public function delivery_address()
    {
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function address()
    {
        return $this->belongsTo(DeliveryAddress::class, 'delivery_address_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function (Order $order) {
            $order->details()->delete();
        });
    }
}
