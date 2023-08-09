<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\API\Atreenode;
use App\Models\API\Aproduct;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DistanceAlert extends Eloquent
{
    use HasFactory;

    protected $table = 'distanceAlert';


    public function product()
    {
        return $this->hasOne(Aproduct::class, '_id','productRef');
    }

    public function aTreeNode()
    {
        return $this->hasOne(Atreenode::class, 'aTreeNodeRef' );
    }
}
