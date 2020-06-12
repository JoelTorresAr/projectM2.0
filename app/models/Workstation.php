<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'name',
      ];
}
