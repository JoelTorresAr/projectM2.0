<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name'
  ];

   /**
     * Get all of the articles for the subsidiary.
     */
    public function posts()
    {
        return $this->hasManyThrough('App\models\Shelf', 'App\models\Articles');
    }
}
