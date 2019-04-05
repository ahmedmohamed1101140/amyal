<?php
/**
 * Created by PhpStorm.
 * User: Abdo Ghaly
 * Date: 10/21/2018
 * Time: 11:40 AM
 */

namespace App;



use Carbon\Carbon;

class uniqueRandom
{

    /**
     * @param $id
     * @param int $count
     * @return string
     *
     * this function accepts the id of the element
     * get it's digits number and generate random numbers
     * uniqid : generate unique random string
     * crc23: chang the string to the hexadecimal format
     * abs: get the absolute of this hexadecimal number
     * substr get the first 3 or 4 digits of the number
     */
    static function generateRND($id,$count=0){
        $max = 6 - strlen($id);
        if($max <= 0){
            return substr(abs(crc32(uniqid())),0,1).$id;
        }
        return substr(abs(crc32(uniqid())),0,$max).$id;
    }

    static function generateRDN($name){
        return strtoupper(substr($name, 0, 2)).substr( abs(crc32(uniqid())),0,4);
    }

    static function generateRDNTrackingNumber(){
        return
            substr(abs(crc32(uniqid())),0,3).
            substr(Carbon::now()->timestamp,-2).
            substr(abs(crc32(uniqid())),0,3).
            substr(abs(crc32(uniqid())),0,3);
    }
}