<?php


namespace App\Helper;


use Illuminate\Support\Str;

class UploadImage
{
    protected static $imageName;
    protected static $imageurl;
    public static function imageUpload ($image, $directory, $modelImage = null)
    {
        if ($image)
        {
            if (isset($modelImage))
            {
                if (file_exists($modelImage))
                {
                    unlink($modelImage);
                }
            }

            self::$imageName = Str::random(10).'.'.$image->getClientOriginalExtension();
            $image->move($directory, self::$imageName);
            self::$imageurl = $directory.self::$imageName;
        }

        else {
            self::$imageurl = $modelImage;
        }

        return self::$imageurl;
    }

}
