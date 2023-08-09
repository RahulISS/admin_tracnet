<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\ProductModel;
use App\Models\Product;
use App\Models\Projects;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProductsController extends Controller
{
    //
    public function product_list()
    {
        $data['products'] = Product::where('is_deleted', 0)->get();
        return view('products.products-list')->with($data);

    }

    public function add_product()
    {
        $data['productModels'] = ProductModel::where('is_deleted', 0)->get();
        $data['projects'] = Projects::where('is_deleted', 0)->get();
        return view('products.add-products')->with($data);
    }

    public function postadd_product(Request $request){
        $fields = Validator::make($request->all(),[
            'serial_id' => 'required|string',
            'productModel_id' => 'required|string',
            'portal_id' => 'required|string',
            'start_date' => 'required',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $product = new Product();
        $product->serial_id = $request->serial_id;
        $product->productModel_id = $request->productModel_id;
        $product->portal_id = $request->portal_id;
        $product->status = $request->status;
        $product->start_date = $request->start_date;        
        $product->is_deleted = 0;
        $product->created_at = now();
        $product->save();

        if($product){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_product(Request $request)
    {   
        if(!empty($request->id)){
            $data['product'] = Product::where(['_id' => $request->id])->first();
            $data['productModels'] = ProductModel::where('is_deleted', 0)->get();
            $data['projects'] = Projects::where('is_deleted', 0)->get();
            return view('products.add-products')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_product(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'serial_id' => 'required|string',
            'productModel_id' => 'required|string',
            'portal_id' => 'required|string',
            'end_date' => 'required',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $product = Product::where('_id', $id)
                            ->update([
                                'serial_id' => $request->serial_id,
                                'productModel_id' => $request->productModel_id,
                                'portal_id' => $request->portal_id,
                                'status' => $request->status,
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,                               
                            ]);
        if($product){
            return redirect(route('productlist'))->with('success', 'Product updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_product($id)
    {
        if($id != ''){
            $deleteProduct = Product::where(['_id' => $id])
            ->update([
                'is_deleted' => 1
               
            ]);
            if($deleteProduct){

                return back()->with('success', 'Unit deleted successfully');
            }else{
                return back()->with('error','Unit deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }
}
