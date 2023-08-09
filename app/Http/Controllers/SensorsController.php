<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Unit;
use App\Models\Sensor;
use App\Models\Projects;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DataTables;

class SensorsController extends Controller
{

    /**
     * Unit ajax data listing for datatable
     */

     public function sensorAjaxData(Request $request){
        if ($request->ajax()) {
            $data = Sensor::where('is_deleted', 0)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('unit',function($row){
                    return $row->units->name;
                })
                ->addColumn('action', function($row){
                    $edit=route('editsensor',$row->id);
                    $delete=route('delete.sensor',$row->id);
                    $actionBtn = '<a href="'.$edit.'" title="edit"><i class="fa fa-pencil" style="color:green"></i></a>&nbsp;&nbsp; <a href="'.$delete.'" title="delete"><i class="fa fa-trash" style="color:red"></i></a>';      
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    //
    public function sensor_list()
    {
        $data['sensors'] = Sensor::where('is_deleted', 0)->get();
        return view('sensors.sensors-list')->with($data);

    }

    public function add_sensor()
    {
        $data['units'] = Unit::where('is_deleted', 0)->get();
        $data['projects'] = Projects::where('is_deleted', 0)->get();
        return view('sensors.add-sensors')->with($data);
    }

    public function postadd_sensor(Request $request){
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        foreach ($request->multiple_portal as $key => $value) {
            $sensor = new Sensor();
            $sensor->name = $request->name;
            $sensor->type = $request->type;
            $sensor->kind = $request->kind;
            $sensor->unit_id = $request->unit;
            $sensor->decimalPlaces = $request->decimalPlaces;
            $sensor->hisFunc = $request->hisFunc;
            $sensor->portal_id = $value;
            $sensor->is_deleted = 0;
            $sensor->created_at = now();
            $sensor->save();
        }
        

        if($sensor){
            
            return back()->with('success', 'Added Successfully'); 
        }else{
            
            return back()->with('error', 'Something went wrong'); 
        }
    }

    public function edit_sensor(Request $request)
    {   
        if(!empty($request->id)){
            $data['sensor'] = Sensor::where(['_id' => $request->id])->first();
            $data['projects'] = Projects::where('is_deleted', 0)->get();
            $data['units'] = Unit::where('is_deleted', 0)->get();
            return view('sensors.add-sensors')->with($data);
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function update_sensor(Request $request, $id)
    {
        $fields = Validator::make($request->all(),[
            'name' => 'required|string',
            'unit' => 'required|string',
        ]);

        if ($fields->fails()) {
            return back()->with('error',$fields->errors());   
        }

        $unit = Sensor::where('_id', $id)
                            ->update([
                                'name' => $request->name,
                                'type' => $request->type,
                                'kind' => $request->kind,
                                'unit_id' => $request->unit,
                                'decimalPlaces' => $request->decimalPlaces,
                                'hisFunc' => $request->hisFunc,
                            ]);
        if($unit){
            return redirect(route('sensorlist'))->with('success', 'Unit updated successfully');
        }else{
            return back()->with('error','Invalid request'); 
        }
    }

    public function delete_sensor($id)
    {
        if($id != ''){
            $deleteUnit = Sensor::where(['_id' => $id])
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
