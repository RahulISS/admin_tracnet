<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Companies;
use Carbon\Carbon;
use InfluxDB2\Client;

class DeviceController extends Controller
{
    //

    public function __construct(){

        // dd(new Client(env('INFLUXDB_HOST'), env('INFLUXDB_PORT'), env('INFLUXDB_USER'), env('INFLUXDB_PASS')));
        // $this->client = new Client(env('INFLUXDB_HOST'), env('INFLUXDB_PORT'), env('INFLUXDB_USER'), env('INFLUXDB_PASS'));

    }

    public function device_list()
    {
        $data['companies'] = Companies::where('is_deleted', 0)->get();
    
        $database = $this->client()->selectDB(env('INFLUXDB_BUCKET'));

        // executing a query will yield a resultset object
        $result = $database->query('select * from airSensors LIMIT 5');
        dd($result);

        // get the points from the resultset yields an array
        $points = $result->getPoints();

        return view('device-ms')->with($data);

    }
}
