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

  /**
   * Get the articles for the shelf.
   */
  public function articles()
  {
    return $this->hasMany('App\models\Articles');
  }
  /**
     * Get the shelf that owns the article.
     */
    public function subsidiary()
    {
        return $this->belongsTo('App\models\Subsidiary');
    }
}
