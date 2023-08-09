<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class userPortal extends Eloquent
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Projects::class,'project_id');
    }

    public function portal()
    {
        return $this->belongsTo(Portals::class,'portal_id');
    }
}
