<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\Aportal;
use App\Models\API\Aproduct;
use App\Models\API\Point;
use Exception;
use MongoDB\BSON\ObjectId;
use App\Models\API\Apointdata;


class MobilePortalController extends Controller
{
    protected $productModelRef = "64ad1b7d664396439a286276"; 

    public function  getAllPortal(){
        try{
            $portalData = Aportal::orderBy('id_name',"ASC")->get();
            return sendResponse($portalData,null);
        }catch(Exception $e){
            return sendError($e->getMessage(), 400);
            return $e->getMessage();
        } 
    }

    public function getSerialID(Request $request){
        try{

            $portalId = Aportal::where( 'id_name' , $request->portal )->first()->id;
            $test = Apointdata::where('aPortalRef' , new ObjectId($portalId))->with('treeNode', 'product')->get();
            $data = [];
            foreach ($test as $key => $value) {
                $data[$key]['prod_data'] =  $value->product->id_serial . ' - ' . $value->treeNode->textLabel;
                $data[$key]['productId'] =  $value->product->id;
            }
        
            return sendResponse($data, "product list");
        }catch(Exception $e){
            return sendError($e->getMessage(), 400);
        } 
    }

    public function  dynamicTable($arg_serial  ){
        
        try{
            $product = Aproduct::where('id_serial',$arg_serial)->select('_id','id_serial','productModelRef')->first();
            if(isset($product))
            {
                $point=Point::where('productRef',new ObjectId($product->_id))->orderBy('timestamp',"DESC")->limit(4)->get();
                return sendResponse($point,null);
            }else{
                return sendError("Data not found", 404);
            }
           
        }catch(Exception $e){
            return sendError($e->getMessage(), 404);
        } 


    }

}
