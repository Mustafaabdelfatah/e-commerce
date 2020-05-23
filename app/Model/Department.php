<?php

namespace App\Moldel;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'dep_name-ar',
        'dep_name-en',
        'icon',
        'description',
        'keyword',
        'parent',
    ];
    
    public function parents()
    {
        return $this->hasMany('App\Model\Department','id','parent_id');
    }

}
