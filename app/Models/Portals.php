<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Portals extends Eloquent
{
    use HasFactory;

    public function projects()
    {
        return $this->hasOne(Projects::class,'_id','project_id');
    }

}
