<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\API\Acustomer;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Aportal extends Eloquent
{
    use HasFactory;
    //aPortal

    protected $table = "aPortal";
    protected $fillable  = ['_id','aCustomerRef','id_name','mod'];

    public function customer() {
        return $this->hasOne(Acustomer::class,'_id','aCustomerRef')->where('id_name','=', 'Gold Coast Water');
    }
}
