<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    //
    public static function checkDir()
    {
        $destinationPath = public_path().'/uploads';
        if (!file_exists($destinationPath)){
            mkdir($destinationPath,0777);
        }
        return $destinationPath;
    }
}
