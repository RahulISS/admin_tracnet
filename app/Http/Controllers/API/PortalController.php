<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\Apointdata;
use App\Models\API\Aportal;
use App\Models\API\Point;
use App\Models\API\Aproduct;
use App\Models\API\Alocation;
use App\Models\API\Atreenode;
use MongoDB\BSON\ObjectId;
use App\Models\API\PointData;
use App\Models\API\ProductSensor;
use App\Models\API\Asensortype;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Collection;
use DB;

class PortalController extends Controller
{
    //

    /** 
     * Get portal id name api 
     * 
     */
    public function getPortal(Request $request){

        $data=Aportal::where('id_name',$request->id_name)->first();
        if($data){
            return sendResponse($data, 'Portal get successfully');
        }
        return sendError('No data found!', 404);

    }

    /**  
     * Get Alert Installation
     * 
     */

     public function getAlertInstallation(Request $request){
        $portal=Aportal::where('id_name',$request->id_name)->first();
        if($portal){
            $portalId=$portal->_id;
            $ApointData=Apointdata::where('aPortalRef',new ObjectId($portalId))->get();
            
            $idsArr=[];
            foreach($ApointData as $a){
                $idsArr[]=$a->productRef->__toString();
            }
            $data=Point::whereIn('productRef',$idsArr)->orderBy('mod','DESC')->first();
        }

        if($data){

            if($data->distanceValue < 300 || $data->angleValue){
                return sendResponse($data, 'Alert installation data get successfully!');
            }
                return sendResponse('', 'Condition not matched for distance value and angel value');
            
        }
        return sendError('No data found!', 404);
    }

    /***
     * 
     * tracnet alarm alert
     */

     public function tracnetAlarmAlert($date=null)
     {
        $ApointData = Apointdata::raw(function (Collection $collection) use ($date1, $date2) {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'product',
                        'localField' => 'productRef',
                        'foreignField' => '_id',
                        'as' => 'product',
                    ],
                ],
                [
                    '$unwind' => '$product',
                ],
                [
                    '$lookup' => [
                        'from' => 'aLocation',
                        'localField' => 'aLocationRef',
                        'foreignField' => '_id',
                        'as' => 'location',
                    ],
                ],
                [
                    '$unwind' => '$location',
                ],
                [
                    '$lookup' => [
                        'from' => 'point',
                        'localField' => 'productRef',
                        'foreignField' => 'productRef',
                        'as' => 'point',
                    ],
                ],
                [
                    '$unwind' => '$point',
                ],
                [
                    '$sort' => [
                        'point.timestamp' => -1,
                    ],
                ],
            ];
        
            $result = $collection->aggregate($pipeline);

            // Convert the result to an array
            $data = $result->toArray();
        
            // Check if the result is empty with the date filter
            if (empty($data)) {
                // Execute the pipeline again without the date filter
                array_pop($pipeline); // Remove the $match stage
        
                $result = $collection->aggregate($pipeline);
        
                // Convert the result to an array
                $data = $result->toArray();
            }
        
            return $data;

        });

        return sendResponse($ApointData, 'You are successfully logged in.');
     }

     public function aLocationData($id){
        $data=Alocation::where('_id',$id)->get();
        
        if(!empty($data)){
            return sendResponse($data, 'Street data found');
        }
        return sendError('No data found!', 404);

     }

     /***
      * 
      Tracnet alarm alert api
      */

      public function tractnetAlarmAlertTab($date=null){

       
        $data = Point::with(['location'])->where( 'aPortalRef' , new ObjectId('64ad1af2664396439a286273'))->get();

      

 
        if ($data->isNotEmpty()) {
            return sendResponse($data, 'Tracnet alarm alert tab get successfully');
        }
            return sendResponse('', 'No data found');
       
        
        // $result = [];
        // $newArr=[];
        //     $portal=Aportal::where('id_name','tracnet trial 20230703')->select('_id')->first();
        //     $ApointData=Apointdata::where('aPortalRef',new ObjectId($portal->_id))->select('_id','productRef','aTreeNodeRef','aLocationRef')->get();
        //     foreach($ApointData as $key=>$a){
        //         $productData=Aproduct::where('_id',new ObjectId($a->productRef->__toString()))->first();
        //         $pointData=Point::where('productRef',new ObjectId($productData->_id))->latest('timestamp')->first();
        //         if($pointData){
                    
        //             $installationName=Atreenode::where('_id',new ObjectId($a->aTreeNodeRef))->first();
        //             $locationData=Alocation::where('_id',new ObjectId($a->aLocationRef))->first();
        //             $result['aTreeNodeRef'] = $installationName->_id;
        //             // $result['installationName'] = $installationName->textLabel;
        //             $result['aTreeNode_textLabel'] = $installationName->textLabel;                    
        //             $result['product_serialNumber']=$productData->id_serial;
        //             $result['latitude'] =  $locationData !== null && $locationData->street !== "" ? $locationData->latitude : null;
        //             $result['longitude'] =  $locationData !== null && $locationData->street !== "" ? $locationData->longitude : null;
                   
    
        //               // Distance value condition start here
        //               $result['Distance']=$pointData->distanceValue;
        //               $result['disColorRank'] = 3;
        //               $result['disColor'] = 'Green';
        //               $result['distance_alarm_tr'] = "";
        //               $result['status'] = ''; 
      
        //               if($pointData->distanceValue > 3998){
        //                   $result['distanceValue']='';
        //                   $result['disColorRank'] = 3;
        //                   $result['disColor'] = 'Green';
        //               }
        //               if($pointData->distanceValue < 300){
        //                   $result['Distance']='400 mm'; 
        //                   $result['distance_alarm_tr'] = "Distance alarm Triggered";
        //                   $result['status'] = 'Distance alarm Triggered'; 
        //                   $result['disColorRank'] = 1;
        //                   $result['disColor'] = 'Red';
        //               }
    
        //               $lastPointData=Point::where('productRef',new ObjectId($productData->_id))->latest('timestamp')->first();
        //               $startDate = date("d-m-Y H:i:s",$lastPointData->timestamp);
        //               $endDate = date('d-m-Y H:i:s');
      
        //               $start_time = new Carbon($startDate);
        //               $end_time = new Carbon($endDate);
      
        //               $diff=$start_time->diff($end_time)->format('%H');
    
        //               $result['message']='';
        //               $result['oldest_comm_date']=$diff . 'hours ago';
        //               $result['time']=$diff . 'hours ago';                      
        //               $result['street'] = $locationData->street ?? ''; 
        //               $newArr[]=$result;
        //         }
                
        //     }
        //     return sendResponse($newArr, 'Tracnet alaram alert tab data fetched successfully');

      }
}
