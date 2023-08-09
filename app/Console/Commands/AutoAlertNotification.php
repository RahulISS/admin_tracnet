<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\AlertMail;
use App\Models\API\Point;
use MongoDB\BSON\ObjectId;

class AutoAlertNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto alert email and sms notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data=Point::where('_id','64ae9f6befa8baae8f106bfb')->select('_id','distanceValue','angleValue')->first();

        if($data->distanceValue < 300){
            Mail::to('jogender@infinitysoftsystems.com')->send(new AlertMail());
        }

        if($data->angleValue < 5){
            Mail::to('jogender@infinitysoftsystems.com')->send(new AlertMail());
        }
        
    }
}
