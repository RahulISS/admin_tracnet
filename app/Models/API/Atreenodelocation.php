<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Atreenodelocation extends Eloquent
{
    use HasFactory;

    //aTreeNodeLocation
    protected $table = "aTreeNodeLocation";
    protected $fillable  = ['_id','aTreeNodeRef','aLocationRef','mod'];

}
