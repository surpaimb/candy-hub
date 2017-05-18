<?php

namespace GetCandy\Api\Products\Models;

use Illuminate\Database\Eloquent\Model;
use GetCandy\Api\Products\Models\ProductFamily;
use GetCandy\Api\Attributes\Models\Attribute;
use GetCandy\Api\Traits\Hashids;

class Product extends Model
{
    use Hashids;

    protected $hashids = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withTimestamps();
    }
    public function family()
    {
        return $this->belongsTo(ProductFamily::class, 'family_id');
    }
}
