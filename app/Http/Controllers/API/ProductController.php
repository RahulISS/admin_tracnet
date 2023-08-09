<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\Aproduct;
use App\Models\API\Atreenode;
use App\Models\API\PointData;
use App\Models\API\ALocation;
use App\Models\API\Apointdata;
use App\Models\API\ProductDetails;
use App\Models\API\Atreenodelocation;
use App\Models\API\ProductImages;
use MongoDB\BSON\ObjectId;
use App\Models\API\Asensortype;
use App\Models\API\aTracNetMobileConfigSetting;
use App\Models\API\ProductSensor;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductController extends Controller
{
    protected  $aCustomerRef = "64ad198f664396439a28626f";
    protected  $aProductModelRef = "64ad1b7d664396439a286276";
    protected  $aTreeNodeRef = "64ae5888efa8baae8f106bb0";
    protected  $aPortalRef = "64ad1af2664396439a286273";
    protected  $aTreeRef = "64ad1d5d664396439a286281";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {

            $productData = new Aproduct;
            $productData->CustomerRef = new ObjectId($this->aCustomerRef);
            $productData->productModelRef = new ObjectId($this->aProductModelRef);  
            $productData->id_serial = strval($request->id_serial);
            $storeProduct = $productData->save();
            if ($storeProduct) {
                //inserting productSensor data
                $sensors = Asensortype::get();
                foreach ($sensors as $key => $sensor) {
                    $prodSensor = new ProductSensor;
                    $prodSensor->productRef = new ObjectId($productData->id);
                    $prodSensor->sensorRef = new ObjectId($sensor->id);
                    $prodSensor->save();
                }

                //inserting aTreeNode data
                $rankNo = Atreenode::orderBy('mod', 'asc')->first()->rank;
                $treeNodeData = new Atreenode;
                $treeNodeData->aTreeNodeRef = new ObjectId($this->aTreeNodeRef);
                $treeNodeData->aTreeRef = new ObjectId($this->aTreeRef);
                $treeNodeData->aPortalRef = new ObjectId($this->aPortalRef);
                $treeNodeData->rank = $rankNo + 1;
                if( $request->text ) {
                    $textLabel = strval($request->text);
                } else {
                    $textLabel = strval($request->id_serial);
                }
                $treeNodeData->textLabel = $textLabel;
                $storeTextLabel = $treeNodeData->save();
                if ($storeTextLabel) {
                    //location check
                    $checkLocation = ALocation::where(['latitude' => $request->latitude, 'longitude' => $request->longitude])->first();
                    $treeLocation = new Atreenodelocation;
                    $point = new PointData;
                    //if exist use existing id
                    if ($checkLocation) {

                        $treeLocation->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $treeLocation->aLocationRef = new ObjectId($checkLocation->_id);

                        $point->productRef = new ObjectId($productData->id);
                        $point->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $point->aLocationRef = new ObjectId($checkLocation->_id);
                        $point->aPortalRef = new ObjectId($this->aPortalRef);
                    } else { //else insert new location
                        $locationData = new ALocation;
                        $locationData->latitude = $request->latitude;
                        $locationData->longitude = $request->longitude;
                        $locationData->city = $request->city;
                        $locationData->street = $request->street;
                        $locationData->state = $request->state;
                        $locationData->postcode = $request->postcode;
                        $locationData->tz = $request->timezone;
                        $locationData->aCustomerRef = new ObjectId($this->aCustomerRef);
                        $saveLocation = $locationData->save();

                        $treeLocation->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $treeLocation->aLocationRef = new ObjectId($locationData->id);


                        $point->productRef = new ObjectId($productData->id);
                        $point->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $point->aLocationRef = new ObjectId($locationData->id);
                        $point->aPortalRef = new ObjectId($this->aPortalRef);
                    }

                    $saveTreeLocation = $treeLocation->save();
                    $storePoint = $point->save();
                    //saving product details
                    $details = new ProductDetails;
                    $details->productRef = new ObjectId($productData->id);
                    $details->aTreeNodeRef = new ObjectId($treeNodeData->id);
                    $details->aPortalRef = new ObjectId($this->aPortalRef);
                    $details->type = $request->optionsTypes;
                    $details->bench = $request->bench;
                    $details->invert = $request->invert;
                    $details->diameter = $request->diameter;
                    $details->siteNotes = $request->siteNotes;
                    $saveDetails = $details->save();

                    //saving product images
                    if ($request->file('file')) {
                        $images = $request->file('file');
                        foreach ($images as $key => $image) {

                            if ($request->hasFile('file') && $request->file('file')[$key]->isValid()) {
                                $path = $request->file[$key]->store('public/images');
                                $path = basename($path);

                                $image = new ProductImages;
                                $image->photo = $path;
                                $image->productRef = new ObjectId($productData->id);
                                $image->save();
                            }
                        }
                    }
                }
                return sendResponse($storePoint, 'Device Added Successfully!');
            }
        } catch (exception $e) {
            return $e;
        }
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
    public function update(Request $request)
    {
        $rules = [
            'productSerial' => 'required',
            'siteName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return  array('status' => 400, 'message' => $validate->errors()->first(), 'data' => null);
        }

        try {
            $product = Aproduct::where('id_serial', $request->productSerial)->first();
            // return $product;
            if ($product != null) {
                $apointData = PointData::where('productRef', new ObjectId($product->id))->first();
                $aLocationRef = new ObjectId($apointData->aLocationRef);

                $getImages = ProductImages::where('productRef', new ObjectId($product->id))->get();
                if ( $request->file('file') ) {
                    $images = $request->file('file');
                    foreach ($images as $key => $image) {

                        if ($request->hasFile('file') && $request->file('file')[$key]->isValid()) {
                            $path = $request->file[$key]->store('public/images');
                            $path = basename($path);

                            $img_arr[$key] = [
                                'photo' => $path,
                                'productRef' => new ObjectId($apointData->productRef),
                                'created_at' => now(),
                                'updated_at' => now()
                            ];                        
                        }
                    }
                }
               
                if($getImages->count() > 0) {

                    // delete exists images
                    foreach($getImages as $key=>$item) {
                        $id =  new ObjectId($item->id);
                        $img_update = ProductImages::find($id);
                        $file_path = storage_path().'/app/public/images/'. $img_update->photo;
                        Storage::delete($file_path);
                        $img_update->delete();
                    }

                    // insert new images
                    $img_insert = ProductImages::insert($img_arr);
                }
                else {
                    $img_insert = ProductImages::insert($img_arr);
                }
                $location_arr = [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postcode' => $request->postcode,
                    'tz' => $request->timeZone,
                ];

                // update location
                $update_aLocation = ALocation::where('_id', new ObjectId($aLocationRef->__toString()))->update($location_arr);

                $extraValues_arr = [
                    'sewer' => $request->sewer,
                    'bench' => $request->depthToBench,
                    'invert' => $request->depthToInvert,
                    'diameter' => $request->diameter
                ];

                $setting = aTracNetMobileConfigSetting::where('aTreeNodeRef', new ObjectId($apointData->aTreeNodeRef->__toString()))->first();

                $setting_update = 0;
                if ($setting != null) {
                    $setting_update = aTracNetMobileConfigSetting::where('aTreeNodeRef', new ObjectId($apointData->aTreeNodeRef->__toString()))->update($extraValues_arr);
                } else {
                    $extraValues_arr_insert = [
                        'sewer' => $request->sewer,
                        'bench' => $request->depthToBench,
                        'invert' => $request->depthToInvert,
                        'diameter' => $request->diameter,
                        'aPortalRef' => $apointData->aPortalRef,
                        'aTreeNodeRef' => $apointData->aTreeNodeRef
                    ];
                    $setting_insert = aTracNetMobileConfigSetting::where('aTreeNodeRef', new ObjectId($apointData->aTreeNodeRef->__toString()))->create($extraValues_arr_insert);
                }

                // update aTreeNode TextLabel
                if ($update_aLocation == 1) {
                    $update_aTreeNodeTextLabel = Atreenode::where('_id', new ObjectId($apointData->aTreeNodeRef->__toString()))->update(['textLabel' => strval($request->siteName)]);
                    if ($update_aTreeNodeTextLabel == 1) {
                        if ($setting_update == 1) {
                            return response()->json(array('status' => true, 'message' => 'updated successfully'));
                        } else if ($setting_insert->length > 0) {
                            return response()->json(array('status' => true, 'message' => 'updated successfully'));
                        } else {
                            return response()->json(array('status' => false, 'message' => 'extra does not save values saves'));
                        }
                    } else {
                        return response()->json(array('status' => false, 'message' => 'Location not updated'));
                    }
                } else {
                    return response()->json(array('status' => false, 'message' => 'Location not updated'));
                }
            } else {
                return response()->json(array('status' => false, 'message' => 'This serial id does not exists'));
            }
        } catch (Exception $e) {
            return $e;
        }
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
}
