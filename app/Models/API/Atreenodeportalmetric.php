<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atreenodeportalmetric extends Model
{
    use HasFactory;
    //aTreeNodePortalMetric
    protected $table = "aTreeNodePortalMetric";
    protected $fillable  = ['_id','aPortalMetricRef','aTreeNodeRef','mod'];
}
