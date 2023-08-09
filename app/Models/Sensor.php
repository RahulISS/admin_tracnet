<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Sensor extends Eloquent
{
    use HasFactory;

    public function units()
    {
        return $this->hasOne(Unit::class,'_id','unit_id');
    }
    
}
