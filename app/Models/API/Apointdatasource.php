<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apointdatasource extends Model
{
    use HasFactory;

    //aPointDataSource

    protected $table = "aPointDataSource";
    protected $fillable  = ['_id','pointRef','productRef','ts_start','type','tz','unit','mod'];
}
