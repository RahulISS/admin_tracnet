<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Atree extends Eloquent
{
    use HasFactory;
    //aTree

    protected $table = "aTree";
    protected $fillable  = ['_id','aPortalRef','mod'];
}
