<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Projects extends Eloquent
{
    use HasFactory;

    public function company()
    {
        return $this->hasOne(Companies::class,'_id','company_id');
    }

    public function portal()
    {
        return $this->hasMany(Portals::class,'project_id');
    }

    public function portal_type()
    {
        return $this->hasOne(portalTypes::class,'_id','portal_Types_id');
    }
}

