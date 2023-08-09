<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Point extends Eloquent
{
    use HasFactory;

    protected $table = "point";
    protected $fillable  = ['_id','productRef','timestamp','mod','aPointDataRef','angleValue','distanceValue','signalStrengthValue','temperatureValue','voltageValue'];

    public $timestamps = false;

    public function products(){
        return $this->hasMany(App\Models\API\Aproduct::class,'_id','productRef');
    }

     public function product() {
        return $this->hasOne(Aproduct::class,'_id','productRef');
    }

    public function treeNode() {
        return $this->hasOne(Atreenode::class,'_id','aTreeNodeRef');
    }

    public function location() {
        return $this->hasOne(ALocation::class,'_id','aLocationRef');
    }


}
