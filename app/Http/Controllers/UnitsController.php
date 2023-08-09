<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Unit;
use App\Models\Projects;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DataTables;

class UnitsController extends Controller
{
    /**
     * Unit ajax data listing for datatable
     */

     public function unitAjaxData(Request $request){
        if ($request->ajax()) {
            $data = Unit::where('is_deleted', 0)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $edit=route('editunit',$row->id);
                    $delete=route('delete.unit',$row->id);
                    $actionBtn = '<a href="'.$edit.'" title="edit"><i class="fa fa-pencil" style="color:green"></i></a>&nbsp;&nbsp; <a href="'.$delete.'" title="delete"><i class="fa fa-trash" style="color:red"></i></a>';      
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function unit_list()
    {
        return view('units.units-list');

    }

    public function add_unit()
    {
        $data['units'] = Unit::where('is_deleted', 0)->get();
        return view('units.add-units')->with($data);
    }

    public function postadd_unit(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->unit = $request->unit;
        $unit->is_deleted = 0;
        $unit->created_at = now();
        $unit->save();

        if($unit){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_unit(Request $request)
    {   
        if(!empty($request->id)){
            $data['unit'] = Unit::where(['_id' => $request->id])->first();
            return view('units.add-units')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_unit(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $unit = Unit::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                                'unit' => $request->unit
                            ]);
        if($unit){
            return redirect(route('unitlist'))->with('success', 'Unit updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_unit($id)
    {
        if($id != ''){
            $deleteUnit = Unit::where(['_id' => $id])
            ->update([
                'is_deleted' => 1
               
            ]);
            if($deleteUnit){

                return back()->with('success', 'Unit deleted successfully');
            }else{
                return back()->with('error','Unit deleted failed'); 
            }
            
        }else{
            return back()->with('error','Invalid request');
        }   
    }
}
