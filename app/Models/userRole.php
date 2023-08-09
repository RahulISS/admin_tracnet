<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class userRole extends Eloquent
{
    use HasFactory;

    protected $table = 'user_roles';

    public function roles()
    {
        return $this->belongsTo(Roles::class,'role_id');
    }
}