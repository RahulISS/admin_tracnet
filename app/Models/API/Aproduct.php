<?php
namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\API\Aproductmodel;
use App\Models\API\Point;
use App\Models\API\Apointdata;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Aproduct extends Eloquent
{
    use HasFactory;
    //product

    protected $table = "product";
    protected $fillable  = ['_id','a
    CustomerRef','id_serial','productModelRef','mod'];

    public function productModel(){
        return $this->hasOne(Aproductmodel::class,'_id',"productModelRef");
    }
    public function aCustomer() {
        return $this->hasOne(Acustomer::class,'_id','aCustomerRef')->where('id_name','=', 'Gold Coast Water');
    }

    public function point(){
        return $this->hasMany(Point::class,'_id','productRef');
    }

    public function Apointdata(){
        return $this->belongsTo(Apointdata::class,'productRef','_id');
    }

}

