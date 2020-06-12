<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    protected $fillable = [
        'subsidiary_id',
        'name',
        'rentalstatus',
        'dealer_id'
      ];
}
