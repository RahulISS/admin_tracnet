<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Permissions extends Eloquent
{
    use HasFactory;

    public function project()
    {
        return $this->hasOne(Projects::class, '_id' , 'project_id' );
    }
    
    public function portal()
    {
        return $this->hasOne(Portals::class, '_id' , 'portal_id' );
    }
    
    public function role()
    {
        return $this->hasOne(Roles::class, '_id' , 'role_id' , '_id');
    }
}
