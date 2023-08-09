<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    use HasFactory;

    public function portal()
    {
        return $this->hasOne(Portals::class,'_id','portal_id');
    }

    public function productModel()
    {
        return $this->hasOne(ProductModel::class,'_id','productModel_id');
    }
    
}
