<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProductModelsController extends Controller
{
    //
    public function product_model_list()
    {
        $data['productModels'] = ProductModel::where('is_deleted', 0)->get();
        return view('productModels.productModels-list')->with($data);

    }

    public function add_product_model()
    {
        $data['productModels'] = ProductModel::where('is_deleted', 0)->get();
        return view('productModels.add-productModels')->with($data);
    }

    public function postadd_product_model(Request $request){
        $fields = Validator::make($request->all(),[
            'modelId' => 'required|string',
            'modelName' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $productModel = new ProductModel();
        $productModel->modelId = $request->modelId;
        $productModel->modelName = $request->modelName;
        $productModel->description = $request->description;
        $productModel->is_deleted = 0;
        $productModel->created_at = now();
        $productModel->save();

        if($productModel){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_product_model(Request $request)
    {   
        if(!empty($request->id)){
            $data['productModel'] = ProductModel::where(['_id' => $request->id])->first();
            return view('productModels.add-productModels')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_product_model(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'modelId' => 'required|string',
            'modelName' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $productModel = ProductModel::where('_id', $id)
                            ->update([
                                'modelId' => $request->modelId,
                                'modelName' => $request->modelName,
                                'description' => $request->description,                                
                            ]);
        if($productModel){
            return redirect(route('productModellist'))->with('success', 'Product Model updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_product_model($id)
    {
        if($id != ''){
            $deleteProductModel = ProductModel::where(['_id' => $id])
            ->update([
                'is_deleted' => 1
               
            ]);
            if($deleteProductModel){

                return back()->with('success', 'Product Model deleted successfully');
            }else{
                return back()->with('error','Product Model deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }
}
