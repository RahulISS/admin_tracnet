<?php
namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\API\Aproduct;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Aproductmodel extends Eloquent
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "productModel";

    protected $fillable  = ['_id','description','modelId','modelName','mod'];


    public function product(){
        return $this->belongsTo(Aproduct::class);
    }





}

