<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public static function getSettingByKey($key)
    {
        return self::where('key',$key)->first();
    }

    public static function saveSettingByKey($key,$value)
    {
        $setting = self::getSettingByKey($key);
        if($setting)
        {
            $setting->update([
                'value' => $value
            ]);
        }
        else
        {
            $setting = self::create([
                'key' => $key,
                'value' => $value
            ]);
        }



        return $setting;
    }
}
