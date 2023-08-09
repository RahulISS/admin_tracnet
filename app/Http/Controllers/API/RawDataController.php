<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\RawData;
use DB;
use Exception;
use Carbon\Carbon;
use App\Models\API\Point;
use App\Models\API\Aproduct;
use App\Jobs\ImportRawDataJob;
use DateTime;
use MongoDB\BSON\ObjectId;


class RawDataController extends Controller
{

    public function getRawData(Request $request){


        // dd(date("Y-m-d_H-i-s", 1689292837));
        // $dateString = "2023-07-14_00-00-37";
        // $date = DateTime::createFromFormat('Y-m-d_H-i-s', $dateString);
        // $timestamp = $date->getTimestamp();
        // dd($timestamp);
        // $date = date('Y-m-d H:i:s', $timestamp);

        $date=null;
        if($request->query('date')){
            $date = $request->query('date'); 
        } else{
            $date = date('Y-m-d');
        } 


    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
        return sendError("Invalid date formate,Date format should be aceept yyyy-mm-dd ", 400);
    } 
       ImportRawDataJob::dispatch($date);  
}

}
