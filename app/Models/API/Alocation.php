<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ALocation extends Eloquent
{
    use HasFactory;
    //aLocation

    protected $table = "aLocation";

}
