<?php
namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\API\Aproduct;
use App\Models\API\ALocation;
use App\Models\API\Atreenode;

class Apointdata extends Eloquent
{
    use HasFactory;
    //aPointData

    protected $table = "aPointData";

    public function product() {
        return $this->hasOne(Aproduct::class,'_id','productRef');
    }

    public function treeNode() {
        return $this->hasOne(Atreenode::class,'_id','aTreeNodeRef');
    }

    public function location() {
        return $this->hasOne(ALocation::class,'_id','aLocationRef');
    }

    // public function point() {
    //     return $this->hasOne(Apoint::class,'_id','pointRef');
    // }

    public function atreenode(){
        return $this->hasOne(Atreenode::class,'_id','aTreeNodeRef');
    }

    public function portal() {
        return $this->hasOne(Aportal::class,'_id','aPortalRef')->where('id_name', 'tracnet trial 20230703');
    }

    public function point() {
        return $this->hasOne(Point::class,'productRef','productRef');
    }
    
}
