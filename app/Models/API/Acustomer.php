<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Acustomer extends Eloquent
{
    use HasFactory;
    //aCustomer

    protected $table = "aCustomer";
    protected $fillable  = ['_id','id_name','longName','shortName','mod'];

    public function aPortal()
    {
        return $this->hasOne('App\Models\API\Aportal','aCustomerRef');
    }
}
