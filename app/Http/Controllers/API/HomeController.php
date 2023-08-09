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
use MongoDB\BSON\UTCDateTime;
use App\Models\API\PointData;
use App\Models\API\ProductSensor;
use App\Models\API\Asensortype;
use App\Models\API\DistanceAlert;
use Carbon\Carbon;
use App\Models\API\Setting;
use Validator;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Collection;
use DB;

class HomeController extends Controller
{
    protected  $aProductModelRef = "64ae5888efa8baae8f106bb0";
    protected  $aPortalName = "tracnet trial 20230703";
    protected  $aCustomerName = "Gold Coast Water";

    public function NewtraknetApiList($date = null)
    {

    
        $startDate = $date.' 00:00:00';
        $start = new \MongoDB\BSON\UTCDateTime(strtotime($startDate) * 1000);
        
        $carbonEDate = $date.' 23:59:59';
        $endDate = new \MongoDB\BSON\UTCDateTime(strtotime($carbonEDate) * 1000);
        
        $startDateTime = Carbon::parse($startDate, 'Asia/Singapore');
        $endDateTime = Carbon::parse($carbonEDate, 'Asia/Singapore')->endOfDay();

        $startUTC = new UTCDateTime($startDateTime->timestamp * 1000);
        $endUTC = new UTCDateTime($endDateTime->timestamp * 1000);
              

        

            // $targetDate = Carbon::parse('2023-07-13 ');
        
            if($date!=null){
                $ApointData = Apointdata::raw(function (Collection $collection) use ($startUTC, $endUTC) {
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
                        !empty($startUTC) && !empty($endUTC) ?
                        [
                            '$match' => [
                                'point.created_at' => [
                                    '$gte' => $startUTC,
                                    '$lte' => $endUTC,
                                ],
                            ],
                        ] : [], 
                        [
                            '$sort' => [
                                'point.timestamp' => -1,
                            ],
                        ],
                        [
                            '$lookup' => [
                                'from' => 'aTreeNode',
                                'localField' => 'aTreeNodeRef',
                                'foreignField' => '_id',
                                'as' => 'treenode',
                            ],
                        ],
                        [
                            '$unwind' => '$treenode',
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

            }
            else{

                $ApointData = Apointdata::raw(function (Collection $collection){
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
                        [
                            '$lookup' => [
                                'from' => 'aTreeNode',
                                'localField' => 'aTreeNodeRef',
                                'foreignField' => '_id',
                                'as' => 'treenode',
                            ],
                        ],
                        [
                            '$unwind' => '$treenode',
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

            }
           
            return sendResponse($ApointData, 'You are successfully logged in.');
        }
        




    public function treenodeVal(Request $request)
    {
        $data = [];
        $productId = PointData::where( 'aTreeNodeRef' , new ObjectId($request->aTreeNodeId))->first()->productRef;
      
        $productSensor = ProductSensor::where( 'productRef' , $productId )->get();
        if( $productSensor ) {
            foreach ( $productSensor as $key => $value ) {
                
                $sensorRef=Asensortype::where('_id',new ObjectId($value->sensorRef))->first();
                $PointRef=Point::where('productRef',new ObjectId($value->productRef))->latest('datetime')->first();

                $data[$key]['decimalPlaces'] = $sensorRef->decimalPlaces !== null && $sensorRef->decimalPlaces !== "" ? $sensorRef->decimalPlaces : null;
                if( $value->sensorRef->__toString() == '64ae522eefa8baae8f106b9d') {
                    if( $PointRef->distanceValue < 300 ){
                        $data[$key]['hisEndVal'] = "400mm";
                    } elseif ( $PointRef->distanceValue > 3998 ) {
                        $data[$key]['hisEndVal'] = "";
                    } else {
                        $data[$key]['hisEndVal'] = $PointRef->distanceValue;
                    }
                }
                else{
                    $data[$key]['hisEndVal'] = "";
                }

                $data[$key]['id'] = $value->sensorRef->__toString();
                $data[$key]['id_name'] = $sensorRef->id_name !== null && $sensorRef->id_name !== "" ? $sensorRef->id_name : null;
                $data[$key]['kind'] = $sensorRef->kind !== null && $sensorRef->kind !== "" ? $sensorRef->kind : null;
                $data[$key]['mod'] = $sensorRef->mod !== null && $sensorRef->mod !== "" ? $sensorRef->mod : null;
                $data[$key]['rank'] =  $sensorRef->rank !== null && $sensorRef->rank !== "" ? $sensorRef->rank : null;
                $data[$key]['unit'] = $sensorRef->unit !== null && $sensorRef->unit !== "" ? $sensorRef->unit : null;
                $data[$key]['unit_common'] = null;
                $data[$key]['type'] = $sensorRef->type !== null && $sensorRef->type !== "" ? $sensorRef->type : null;

            }
            return sendResponse($data, 'You are successfully logged in.');
        }
        
    }

    /**
     * get user defined distance alert
     */
    public function userDefinedDistanceAlert(Request $request){
        $data = DistanceAlert::where('aTreeNodeRef', new ObjectId($request->aTreeNodeRef))->with('product')->first();
        if($data){
            return sendResponse($data, 'Distance alert data fetched successfully');
        }
        return sendResponse('', 'No data found');

    }

    /**
     * 
     * Save user defined distance alert
     */
    public function addUserDefinedDistanceAlert(Request $request){
        $insert=DistanceAlert::where('aTreeNodeRef', new ObjectId($request->aTreeNodeRef))->first();
        if($insert==''){
            $insert = new DistanceAlert();
        }
        $treeNode = Atreenode::find(new ObjectId($request->aTreeNodeRef));
        $productId = PointData::where('aTreeNodeRef', new ObjectId($request->aTreeNodeRef))->first()->productRef;
        $proData = Aproduct::find($productId);
    
        $insert->productRef=new ObjectId($proData->id);
        $insert->aTreeNodeRef=new ObjectId($request->aTreeNodeRef);
        $insert->alert_enable=(int)$request->alert_enable;
        $insert->distance_alert=$request->distance_alert;
        $insert->aProductModelRef= new ObjectId($this->aProductModelRef);
        $insert->id_serial=$proData->id_serial;
        $insert->installationName = $treeNode->textLabel;
        $save=$insert->save();
        if($save){
            return sendResponse('', 'Distance alert data saved successfully');
        }
            return sendResponse('', 'Error in data saving');

    }

    public function addSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emailAddress'    => 'required|email'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

        try { 
            $setting = new Setting;
            $setting->customerName = $this->aCustomerName;
            $setting->portalName = $this->aPortalName;    
            $setting->contactName = $request->contactName;
            $setting->email = $request->emailAddress;
            $setting->smsNumber = $request->smsNumber;
            $setting->save();
            return sendResponse($setting, 'Setting Added Successfully!');
        }
        catch (exception $e) {
            return $e;
        }
    }
    

    public function getSettingFormData(Request $request){
        try {

            $getData = Setting::where('portalName' , $request->portalName)->first();
            return sendResponse($getData, 'Portal Setting Data!');


        } catch (exception $e) {
            return sendError($e);
        }

    }

}
