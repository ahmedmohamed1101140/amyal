<?php
/**
 * Created by PhpStorm.
 * User: Abdo Ghaly
 * Date: 10/24/2018
 * Time: 10:51 AM
 */

namespace App;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;


class FileDownload
{
    static function downloadCSV($filename,$orders,$format){
        \Excel::create($filename, function($excel) use ($orders) {
                $excel->sheet('mySheet', function($sheet) use ($orders)
            {
                $sheet->fromArray($orders);
            });
        })->download($format);
    }

    static function downloadPDF($path,$orders,$filename){
        $pdf = PDF::loadView($path,compact('orders'));
        return $pdf->download($filename);
    }

    static function printPolicy($path,$order,$filename){
        $pdf = PDF::loadView($path,compact('order'));
        return $pdf->download($filename);
    }

    static function printOrderPolicy($path,$order,$filename){
        $pdf = PDF::loadView($path,compact('order'));
        return $pdf->download($filename);
    }
}