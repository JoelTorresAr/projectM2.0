<?php

namespace App\models;

use Bitfumes\Multiauth\Model\Role as RoleModel;

class Role extends RoleModel
{
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];
}
