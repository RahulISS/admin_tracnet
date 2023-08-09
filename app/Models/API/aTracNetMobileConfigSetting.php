<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class aTracNetMobileConfigSetting extends Eloquent
{
    use HasFactory;
    protected $table = "aTracNetMobileConfigSetting";

    protected $fillable  = ['_id','sewer','bench','invert','diameter','aTreeNodeRef', 'aPortalRef', 'mod'];

}
