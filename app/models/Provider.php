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
    
     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * The articles that belong to the provider.
     */
    public function articles()
    {
        return $this->hasMany('App\models\Article');
    }
}
