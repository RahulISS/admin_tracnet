<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\Asensortype;
use App\Models\API\Atreenode;
use App\Models\API\Aportal;
use MongoDB\BSON\ObjectId;
use App\Models\API\PointData;
use App\Models\API\Aproduct;
use App\Models\API\Point;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;
use DateTime;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success = Atreenode::whereNotNull( 'aTreeNodeRef' )->orderBy('rank', 'asc')->get();
        return sendResponse($success, 'List of Tree Nodes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listAllSensors()
    {
        $success = Asensortype::orderBy('rank', 'asc')->get();
        return sendResponse($success, 'List of Sensors');
    }

    public function getDeviceId( Request $request) {

        $portalId =  Aportal::where( 'id_name' , $request->portal )->first()->id;
        $aTreeNodeId =  Atreenode::where( 'textLabel' , $request->aTreeNode )->first()->id;
        $data = PointData::where(['aPortalRef' => new ObjectId($portalId) , 'aTreeNodeRef' => new ObjectId($aTreeNodeId)])->first()->productRef;
        $productData = Aproduct::where('_id', new ObjectId($data))->first();
        $data = [
            "productRef" => $productData->_id,
            "id_serialNumber" => $productData->id_serial
        ];
        
        return sendResponse($data, 'Device Id');
    }

    public function getDeviceData( Request $request) {
        
        $data = [];
        $productId = PointData::where( 'aTreeNodeRef' , new ObjectId($request->aTreeNodeId))->first()->productRef;
        
        
                $startDateTime = Carbon::parse($request->startDate, 'Asia/Singapore');
                $endDateTime = Carbon::parse($request->startDate, 'Asia/Singapore')->endOfDay();
                

            // $startDate =$request->startDate; // Replace with the desired start date
            // $endDate = $request->startDate; // Replace with the desired end date

            $startUTC = new UTCDateTime($startDateTime->timestamp * 1000);
            $endUTC = new UTCDateTime($endDateTime->timestamp * 1000);

            // // Convert the start and end dates to UTCDateTime objects
            // $startUTC = new UTCDateTime(strtotime($startDate) * 1000);
            // $endUTC = new UTCDateTime(strtotime($endDate) * 1000);

            // MongoDB query to retrieve matching records
            $pointRecords = Point::raw(function ($collection) use ($productId, $startUTC, $endUTC) {
                return $collection->find([
                    'productRef' => $productId,
                    'created_at' => [
                        '$gte' => $startUTC,
                        '$lte' => $endUTC,
                    ],
                ]);
            });
            return sendResponse($pointRecords, 'You are successfully logged in.');

        $pointRecords = Point::whereBetween('created_at', [strtotime($startDate), strtotime($endDate)])->get();

        
        
        if( $request->has('endDate') ) {
            $pointRecords = Point::where( 'productRef' , $productId )->whereBetween('datetime', [ $startDate , $endDate  ])->get();
        }  else {
            $pointRecords = Point::where('productRef' , $productId)->whereBetween('datetime', [ $startDate , $startDateEnd  ])->get();
        }
        
        if( $pointRecords ) {
            foreach ( $pointRecords as $key => $value ) {
                $date = date( 'c' , $value->timestamp );
                //angle
                if( $request->sensorId == new ObjectId('64ae522eefa8baae8f106b98')){
                    $data[$key]['ts'] = $date . ' Singapore';
                    $data[$key]['v0'] = $value->angleValue;
                }

                //distance
                if( $request->sensorId == new ObjectId('64ae522eefa8baae8f106b9d')) {
                    if( $value->distanceValue <= 300 ){
                        $data[$key]['ts'] = $date . ' Singapore';
                        $data[$key]['v0'] = "400mm";
                    } elseif ( $value->distanceValue >= 3998 ) {
                        $data[$key]['ts'] = $date . ' Singapore';
                        $data[$key]['v0'] = "";
                    } else {
                        $data[$key]['ts'] = $date . ' Singapore';
                        $data[$key]['v0'] = $value->distanceValue;
                    }
                }

                //temperature
                if( $request->sensorId == new ObjectId('64ae522eefa8baae8f106b9e')){
                    $data[$key]['ts'] = $date . ' Singapore';
                    $data[$key]['v0'] = $value->temperatureValue;
                }

                //Battery Voltage
                if( $request->sensorId == new ObjectId('64ae522eefa8baae8f106b99')){
                    $data[$key]['ts'] = $date . ' Singapore';
                    $data[$key]['v0'] = $value->voltageValue;
                }

                //Signal Strength
                if( $request->sensorId == new ObjectId('64ae522eefa8baae8f106b9c')){
                    $data[$key]['ts'] = $date . ' Singapore';
                    $data[$key]['v0'] = $value->signalStrengthValue;
                }
               
            }

            return sendResponse($data, 'History Record of device');
        }
    }
}
