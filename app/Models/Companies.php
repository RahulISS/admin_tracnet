<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Companies extends Eloquent
{
    use HasFactory;

    public function location()
    {
        return $this->hasOne(Locations::class,'_id','location_id');
    }

    public function projects()
    {
        return $this->hasMany(Projects::class, 'company_id', '_id');
    }

}

