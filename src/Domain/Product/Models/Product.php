<?php

namespace Domain\Product\Models;

use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Searchable;
use Support\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Searchable;

    protected $fillable = [
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'sorting',
        'on_home_page',
        'text',
        'json_properties'
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }


    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];


    public function newEloquentBuilder($query)
    {
        return new ProductQueryBuilder($query);
    }


    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();

//        foreach (filters() as $filter) {
//            $query = $filter->apply($query);
//        }
    }



    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::created(function (Product $product) {
            ProductJsonProperties::dispatch($product)
                ->delay(10);
        });

        static::updated(function (Product $model) {
            ProductJsonProperties::dispatch($model)
                ->delay(10);
        });
    }


    protected static function newFactory()
    {
        return ProductFactory::new();
    }


}
