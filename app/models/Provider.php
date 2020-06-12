<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'district_id',
        'address',
        'address2',
        'ruc',
        'name',
        'phone1',
        'phone2',
    ];
}
