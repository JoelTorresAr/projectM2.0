<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
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
     * The dealers that belong to the article.
     */
    public function dealers()
    {
        return $this->belongsToMany('App\Dealer');
    }

    /**
     * The offers that owns to the article.
     */
    public function offer()
    {
        return $this->belongsTo('App\models\Offer');
    }

    /**
     * The provider that owns the article.
     */
    public function provider()
    {
        return $this->belongsTo('App\models\Provider');
    }

    /**
     * Get the category that owns the article.
     */
    public function category()
    {
        return $this->belongsTo('App\models\Category');
    }
    /**
     * Get the shelf that owns the article.
     */
    public function shelf()
    {
        return $this->belongsTo('App\models\Shelf');
    }
    /**
     * Get the subsidiary that owns the article.
     */
    public function subsidiary()
    {
        return $this->belongsToThrough('App\models\Subsidiary', 'App\models\Shelf');
    }

    /**
     * Get the owning articlable model.
     */
    public function articlable()
    {
        return $this->morphTo();
    }
}
