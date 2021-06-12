<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute() {
        return Helper::getMediaUrl($this->image_path);
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    public static function handleUploadImage($model,$image,$path,$is_primary = false)
    {
        $image_data = Helper::uploadFileTo($image, $path);
        $image = self::create([
            'image_path' => $image_data["media_path"],
            'is_primary' => $is_primary ? 'yes' : 'no'
        ]);
        $model->image()->save($image);
    }

    public static function handleReplaceImage($model,$image,$path,$is_primary = false)
    {
        $imagePath = Helper::getMediaPath($model->image);
        $image_data = Helper::deleteFile($imagePath);
        $image = self::create([
            'image_path' => $image_data["media_path"],
            'is_primary' => $is_primary ? 'yes' : 'no'
        ]);
        $model->image()->save($image);
    }
}
