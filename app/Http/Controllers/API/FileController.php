<?php 
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CsvFileImport; // Import your custom import class

use App\Models\API\Aproduct;
use App\Models\API\Atreenode;
use App\Models\API\PointData;
use App\Models\API\ALocation;
use App\Models\API\ProductDetails;
use App\Models\API\Atreenodelocation;
use App\Models\API\ProductImages;
use MongoDB\BSON\ObjectId;
use App\Models\API\Asensortype;
use App\Models\API\ProductSensor;


class FileController extends Controller
{

    protected  $aCustomerRef = "64ad198f664396439a28626f";
    protected  $aProductModelRef = "64ad1b7d664396439a286276";
    protected  $aTreeNodeRef = "64ae5888efa8baae8f106bb0";
    protected  $aPortalRef = "64ad1af2664396439a286273";
    protected  $aTreeRef = "64ad1d5d664396439a286281";

    public function form(){
        return view('form');
    }

    // In YourController
public function import(Request $request)
{
    $file = $request->file('file');
    $rows =  Excel::toArray(new CsvFileImport, $file);

    // read csv file
    $excelData= array_shift($rows);       
    $failed=[];
    $success=[];

    foreach($excelData as $key => $row)
    {


        try {
            
            $productData = new Aproduct;
            $productData->CustomerRef = new ObjectId($this->aCustomerRef);
            $productData->productModelRef = new ObjectId($this->aProductModelRef);    
            $productData->id_serial = $row[0];
            $storeProduct = $productData->save();
            if( $storeProduct ) {
                //inserting productSensor data
                $sensors = Asensortype::get();
                foreach ($sensors as $key => $sensor) {
                    $prodSensor = new ProductSensor;
                    $prodSensor->productRef = new ObjectId($productData->id);
                    $prodSensor->sensorRef = new ObjectId($sensor->id);
                    $prodSensor->save();
                }
                
                //inserting aTreeNode data
                 $rankNo = Atreenode::orderBy('rank', 'desc')->value('rank');

                 if(!isset($rankNo) && $rankNo <1)
                 $rankNo = $key;
   

                $treeNodeData = new Atreenode;
                $treeNodeData->aTreeNodeRef = new ObjectId($this->aTreeNodeRef);
                $treeNodeData->aTreeRef = new ObjectId($this->aTreeRef);
                $treeNodeData->aPortalRef = new ObjectId($this->aPortalRef);
                $treeNodeData->rank = $rankNo + 1;
                $treeNodeData->textLabel = $row[1];
                $storeTextLabel = $treeNodeData->save();
                if( $storeTextLabel ) {
                    //location check
                    $checkLocation = ALocation::where(['latitude' => $row[2] , 'longitude' => $row[3] ])->first();
                    $treeLocation = new Atreenodelocation;
                    $point = new PointData;
                    //if exist use existing id
                    if( $checkLocation ) {

                        $treeLocation->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $treeLocation->aLocationRef = new ObjectId($checkLocation->_id);

                        $point->productRef = new ObjectId($productData->id);
                        $point->aTreeNodeRef = new ObjectId($treeNodeData->id);
                        $point->aLocationRef = new ObjectId($checkLocation->_id);
                        $point->aPortalRef = new ObjectId($this->aPortalRef);
                    } else { //else insert new location
                        $locationData = new ALocation;
                        $locationData->latitude = $row[2];
                        $locationData->longitude = $row[3];
                        $locationData->city = $row[5];
                        $locationData->street = $row[6];
                        $locationData->state = $row[8];
                        $locationData->postcode = $row[4];
                        $locationData->tz = $row[8];
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

                
                    // $details->type = $request->optionsTypes;
                    // $details->bench = $request->bench;
                    // $details->invert = $request->invert;
                    // $details->diameter = $request->diameter;
                    // $details->siteNotes = $request->siteNotes;
                    $saveDetails = $details->save();

                     //saving product images
                     
                    // if ( $request->file('file') ) {
                    //     $images = $request->file('file');
                    //     foreach ($images as $key => $image) {

                    //         if ($request->hasFile('file') && $request->file('file')[$key]->isValid()) {
                    //             $path = $request->file[$key]->store('public/images');
                    //             $path = basename($path);
    
                    //             $image = new ProductImages;
                    //             $image->photo = $path;
                    //                 $image->productRef = new ObjectId($productData->id);
                    //             $image->save();
                    //         }
                    //     }
                    // }
                }
                // return sendResponse($storePoint, 'Device Added Successfully!');
            }
        }
        catch (exception $e) {
            return $e;
        }
       


     
    }
}

   

}
