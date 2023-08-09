<?php

namespace App\Http\Controllers\API;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\Acustomer;
use App\Models\API\Aportal;
use App\Models\API\Atreenodelocation;
use App\Models\API\Atreenode;
use App\Models\API\Alocation;
use App\Models\API\Apointdata;
use MongoDB\BSON\ObjectId;
use App\Models\API\Atree;
use App\Models\API\Timezone;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;
use App\Models\API\Point;

class ApiController extends Controller
{
    protected $treeNodeId = "64ae5888efa8baae8f106baf";
    protected $portalId = "64ad1af2664396439a286273";

    public function aTreeNodeRef(Request $request)
    {
        
        $res = Apointdata::with(['location'])->where('productRef',new ObjectId($request->productRef))->first();
        
        return response()->json(['message'=>'success','status'=>$request->productRef,'data'=>$res]);
    }

    public function getGroupNode(Request $request)
    {
        $portalId =  Aportal::where( 'id_name' , $request->portal )->first()->id;
        $aTreeId =  Atree::where( 'aPortalRef' , new ObjectId($portalId) )->first()->id;
        $treeNode = Atreenode::where([
                        'aTreeRef' => new ObjectId($aTreeId) , 
                        'aTreeNodeRef' => new ObjectId($this->treeNodeId)
                    ])->get();

        return sendResponse($treeNode, 'List of Group Node');
    }

    public function getAllTimeZone(Request $request)
    {
        $location = Timezone::get();
        return sendResponse($location, 'List of tiemzone');
    }

    public function sendAlarmNotification()
    {
        $productsList = Apointdata::where('aPortalRef', new ObjectId($this->portalId))->get();
        $mailBody = [];
        $bodyData = [];
        if( $productsList ){
            foreach ($productsList as $key => $list) {
               
                $lastPoinData = Point::select('angleValue', 'distanceValue', 'productRef', 'timestamp')
                                ->where('productRef', new ObjectId($list->productRef))
                                ->orderBy('timestamp', 'asc')
                                ->first();
               
                $textLabel = Apointdata::with('treeNode', 'location')->where('productRef', new ObjectId($list->productRef))->first();
            
                if($lastPoinData) {
                    $mailBody['installation'] = $textLabel->treeNode->textLabel;
                    $mailBody['angle_value'] = $lastPoinData->angleValue;    
                    $mailBody['distance_value'] = $lastPoinData->distanceValue;
                    $mailBody['address'] = $textLabel->location->street  . $textLabel->location->city;
                    
                    if( $lastPoinData->angleValue > "5" ) {
                        $mailBody['notification_type'] = 'Angle alarm Triggered(> 5deg)';
                        $mailBody['color'] = "Red"; 
                    } 
                    
                    if ($lastPoinData->distanceValue < "300" ) {
                        $mailBody['notification_type'] = 'Distance alarm Triggered (< 300mm)';
                        $mailBody['color'] = "Red";
                    }         
                }
                $bodyData[] = $mailBody;               
            }
           // dd($bodyData);
            if(sizeof($bodyData) > 0){
                $sentEmail = Mail::to("poonam.k@infinitysoftsystems.com")->send(new AlertMail($bodyData));
                if($sentEmail){
                    return sendResponse($sentEmail, 'Email Sent Successfully');
                }
            }
        }
           
    }
}
