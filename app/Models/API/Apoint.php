<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Apoint extends Eloquent
{
    use HasFactory;

    protected $table = "aPoint";
    protected $fillable  = ['_id','aSensorTypeRef','his','hisEnd','hisEndVal','hisSize','hisStart','hisYear23','kind','point','tz','unit','mod'];

    public function aLocation(){
        return $this->hasOne(Alocation::class,'_id','aLocationRef');
    }


}
