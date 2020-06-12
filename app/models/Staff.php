<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
  protected $fillable = [
    'admin_id',
    'subsidiary_id',
    'workposition_id',
    'district_id'    ,
    'address'        ,
    'name'      ,
    'lastname'  ,
    'phone'          ,
    'email',
    'birthday'
  ];

  /**
     * Get the admin record associated with the staff.
     */
    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }
}
