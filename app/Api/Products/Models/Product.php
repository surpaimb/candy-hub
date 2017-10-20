<?php

namespace GetCandy\Api\Products\Models;

use GetCandy\Api\Attributes\Models\Attribute;
use GetCandy\Api\Categories\Models\Category;
use GetCandy\Api\Channels\Models\Channel;
use GetCandy\Api\Collections\Models\Collection;
use GetCandy\Api\Customers\Models\CustomerGroup;
use GetCandy\Api\Layouts\Models\Layout;
use GetCandy\Api\Pages\Models\Page;
use GetCandy\Api\Routes\Models\Route;
use GetCandy\Api\Scaffold\BaseModel;
use GetCandy\Api\Traits\Assetable;
use GetCandy\Api\Traits\CustomerGroup as CustomerGroupTrait;
use GetCandy\Api\Traits\HasAttributes;
use GetCandy\Api\Traits\HasChannels;
use GetCandy\Api\Traits\HasTranslations;
use GetCandy\Api\Traits\Indexable;
use GetCandy\Http\Transformers\Fractal\Products\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use Assetable,
        CustomerGroupTrait,
        HasAttributes,
        HasChannels,
        SoftDeletes,
        Indexable;

    protected $settings = 'products';

    protected $dates = ['deleted_at'];

    public $transformer = ProductTransformer::class;

    /**
     * The Hashid Channel for encoding the id
     * @var string
     */
    protected $hashids = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'attribute_data', 'option_data'
    ];

    public function setOptionDataAttribute($value)
    {
        $options = [];
        foreach ($value as $option) {
            $label = reset($option['label']);
            $options[str_slug($label)] = $option;
            $childOptions = [];
            $position = 1;
            foreach ($option['options'] as $child) {
                $childLabel = reset($child['values']);
                $childOptions[str_slug($childLabel)] = $child;
                $childOptions[str_slug($childLabel)]['position'] = $position;
                $position++;
            }

            $options[str_slug($label)]['options'] = $childOptions;
        }

        $this->attributes['option_data'] = json_encode($options);
    }

    public function getOptionDataAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Get the attributes associated to the product
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class)->withTimestamps();
    }

    /**
     * Get the related family
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(ProductFamily::class, 'product_family_id');
    }

    /**
     * Get the products page
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function page()
    {
        return $this->morphOne(Page::class, 'element');
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    public function route()
    {
        return $this->morphOne(Route::class, 'element');
    }

    public function routes()
    {
        return $this->morphMany(Route::class, 'element');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * Get the attributes associated to the product
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function channels()
    {
        return $this->belongsToMany(Channel::class)->withPivot('published_at');
    }

    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class)->withPivot(['visible', 'purchasable']);
    }
}
