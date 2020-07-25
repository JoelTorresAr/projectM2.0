<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni',
        'igv_id',
        'prooftype_id',
        'paytype',
        'totalpay',
    ];

    /**
     * Get the owning salable model.
     */
    public function salable()
    {
        return $this->morphTo();
    }
}
