<?php

namespace App\models;

use Bitfumes\Multiauth\Model\Permission as PermissionModel;

class Permission extends PermissionModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];
}
