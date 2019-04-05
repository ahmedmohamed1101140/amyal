<?php
/**
 * Created by PhpStorm.
 * User: Abdo Ghaly
 * Date: 9/26/2018
 * Time: 2:05 PM
 */

namespace App;


use File;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class FileUpload
{
    static function upload($file,$path){
        $dir = public_path().$path;
        $fileName =  Uuid::uuid4()->toString().'.'.$file->getClientOriginalExtension();
        $file->move($dir , $fileName);
        return $fileName;
    }

    static function delete_image($image_name,$path){
        $filename = public_path().$path.$image_name;
        if(file_exists($filename)){
            File::delete($filename);
            return true;
        }
        else{
            return false;
        }
    }
}
