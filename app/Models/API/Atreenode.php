<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Atreenode extends Eloquent
{
    use HasFactory; 
    //aTreeNode

    protected $table = "aTreeNode";
    
    protected $fillable  = ['_id','aTreeNodeRef','aTreeRef','rank','textLabel','textMouseRollover','mod'];

    /**
     * Get the comments for the blog post.
     */
    public function aTreeNode()
    {
        return $this->hasMany(Atreenode::class, '_id', 'aTreeNodeRef');
    }
}
