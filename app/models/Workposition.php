<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Workposition extends Model
{

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'name',
        'workstation_id'
    ];
}
