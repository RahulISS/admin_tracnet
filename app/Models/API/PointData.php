<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\API\Aproduct;

class PointData extends Eloquent
{
    use HasFactory;

    protected $table = "aPointData";

    public function product()
    {
        return $this->hasOne(Aproduct::class, 'productRef' );
    }
}
