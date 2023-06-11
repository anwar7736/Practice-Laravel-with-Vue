<?php

namespace App\Utils;

class Util {

    public static function uploadFile($folder, $file)
    {
        $file_name = "";
        if(!empty($folder) && !empty($file))
        {
            $extension = $file->extension();
            $file_name = rand().'.'.$extension;
            $file->move(public_path('images/'.$folder), $file_name);
        }

        return $file_name;
    }

    public static function deleteFile($folder, $file)
    {
        if(!empty($folder) && !empty($file))
        {
            $path = public_path('/images/'.$folder.'/'.$file);
            if(file_exists($path))
            {
                unlink($path);
            }
        }

        return true;
    }
}