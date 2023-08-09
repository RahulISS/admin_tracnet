<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class userPermission extends Eloquent
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user_permissions';

    protected $fillable = [
        'user_id',
        'project_id',
        'portal_id',
        'role_id',
    ];

    public function projects()
    {
        return $this->hasMany(Projects::class , '_id' , 'project_id' );
    }
    
    public function portals()
    {
        return $this->hasMany(Portals::class , '_id' , 'portal_id' );
    }
    
    public function roles()
    {
        return $this->hasMany(Roles::class , '_id' , 'role_id' , '_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, '_id' , 'user_id' );
    }
}
