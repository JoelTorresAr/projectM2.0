<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'discount',
    'active'
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
     * The articles that belong to the offer.
     */
    public function articles()
    {
        return $this->belongsToMany('App\models\Article');
    }

    
    /**
     * Get the owning offerable model.
     */
    public function offerable()
    {
        return $this->morphTo();
    }
}
