<?php
/**
 * Created by PhpStorm.
 * User: Abdo Ghaly
 * Date: 11/7/2018
 * Time: 12:40 PM
 */

namespace App;


class DateReFormat
{
    static function RefactorDate($date){
        $temp = explode('/', $date);
        $val = $temp[1] . '/' . $temp[0] . '/' . $temp[2];
        $formated = date('Y-m-d', strtotime($val));
        return $formated;

    }


}