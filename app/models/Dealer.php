<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admin_id',
        'status',
        'startdate',
        'enddate',
    ];
}
