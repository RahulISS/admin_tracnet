<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\API\RawData;
use DB;
use Exception;
use Carbon\Carbon;
use App\Models\API\Point;
use App\Models\API\Aproduct;
use DateTime;
use MongoDB\BSON\ObjectId;

class ImportRawDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $date ;
     public $request;
     


    public function __construct($date)
    {
       $this->date = $date;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

     
        $date1 = $this->date."_00-00-00";
        $date2 = $this->date."_23-59-59";
        $data = DB::connection('mongodb2')->table('rawdatas')->whereBetween('date', [ $date1,$date2])
         ->select('_id','device_id','temperature','angle','signal_strength','battery_voltage',
         'height','date','battery_status','status','moved_alarm','uploads_since_power_on')->get();


    
         if(count($data) > 0){ 
            foreach($data as $value){
               $products = Aproduct::where('id_serial','=',$value['device_id'])->get();  
               if(count($products) >0 )
                {
                   
                    foreach($products as $product){
                        $dateConvert = DateTime::createFromFormat('Y-m-d_H-i-s', $value['date']);
                        $timestamp = $dateConvert->getTimestamp();
                        $pointExists=Point::where('productRef',new ObjectId($product->productRef))->where('timestamp','!=', $timestamp)->exists();
                                if(!$pointExists){
                                    $point = new Point;
                                    $point->angleValue =   $value['angle'];
                                    $point->productRef =   new ObjectId($product->_id);
                                    $point->temperatureValue =   $value['temperature'];
                                    $point->distanceValue =   $value['height'];
                                    $point->signalStrengthValue =   $value['signal_strength'];
                                 
                                    $point->timestamp =  $timestamp;
                                    $point->datetime = date('Y-m-d H:i:s', $timestamp);
                                    $point->voltageValue =   $value['battery_voltage'];
                                    $point->manholeBatteryStatusValue =   $value['battery_status'];
                                    $point->manholeLevelAlarmValue =   $value['status'];
                                    $point->manholeMovedAlarmValue =   $value['moved_alarm'];
                                    $point->uploadCounterValue =   $value['uploads_since_power_on'];
                                    $point->mod = now();
                                    $point->save();
                                 }else{

                                    $point = new Point;
                                    $point->angleValue =   $value['angle'];
                                    $point->productRef =   new ObjectId($product->_id);
                                    $point->temperatureValue =   $value['temperature'];
                                    $point->distanceValue =   $value['height'];
                                    $point->signalStrengthValue =   $value['signal_strength'];  
                                    $point->timestamp =  $timestamp;
                                    $point->datetime = date('Y-m-d H:i:s', $timestamp);
                                    $point->voltageValue =   $value['battery_voltage'];
                                    $point->manholeBatteryStatusValue =   $value['battery_status'];
                                    $point->manholeLevelAlarmValue =   $value['status'];
                                    $point->manholeMovedAlarmValue =   $value['moved_alarm'];
                                    $point->uploadCounterValue =   $value['uploads_since_power_on'];
                                    $point->mod = now();
                                    $point->save();

                                 }
        
                        }   
                        
                    }
                
                }
        
            }

    }
}
