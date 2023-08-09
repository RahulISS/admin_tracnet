<?php

use Illuminate\Support\Facades\Route;

use InfluxDB2\Client;
use InfluxDB2\Model\QueryAPI;
use InfluxDB2\Model\FluxTable;
use App\Http\Controllers\API\FileController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// http://localhost:8086/write?db=tracknet&u=ayazinf&p=ayazinf@1234


Route::get('/influxdb2-data', function () {
    $url = "http://localhost:8086/write?db=tracknet&u=ayazinf&p=ayazinf@1234";
    $token = "OnzCAJUDtKeEwyCus1ej1LPcyltyru0mDUDEnlSKHFG8WvHFIGJXozN_aZjG2A69DuD-zfeKchgWPVEERbW2g==";
    $org = "NHRS";
    $bucket = "tracknet";


    try {
        // Create a new InfluxDB2 client instance
        $client = new Client([
            'url' => $url,
            'token' => $token,
            'username' =>"ayazinf",
            'password'=>"ayazinf@1234"
        ]);

        // Create a new query API instance
        $queryApi = $client->createQueryAPI();

        // Build a Flux query
        $query = 'from(bucket: "' . $bucket . '") |> range(start: -1h) |> filter(fn: (r) => r._measurement == "airSensors")';

        // Execute the query
        $result = $queryApi->query($query, $org);

   

        // Process the data
        $data = [];
        /** @var FluxTable $table */
        foreach ($result->getTables() as $table) {
            foreach ($table->getRecords() as $record) {
                $data[] = [
                    'time' => $record->getValueByKey('_time'),
                    'field1' => $record->getValueByKey('field1'),
                    'field2' => $record->getValueByKey('field2'),
                    // Add more fields as needed
                ];
            }
        }

        // Return the data
        return response()->json($data);
    } catch (\Exception $e) {
        // Handle any exceptions
        return 'Failed to retrieve data from InfluxDB 2.0: ' . $e->getMessage();
    }
});







Route::get('/upload',[FileController::class,'form']);
Route::post('/upload',[FileController::class,'import']); 




