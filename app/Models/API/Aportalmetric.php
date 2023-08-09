<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aportalmetric extends Model
{
    use HasFactory;
    //aPortalMetric

    protected $table = "aPortalMetric";
    protected $fillable  = ['_id','id_name','kind','name_common','type','mod'];
}
