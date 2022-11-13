<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;

/**
 * @method  static Category|CategoryQueryBuilder query()
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;



    protected $fillable = [
        'slug',
        'title',
        'sorting',
        'on_home_page',
    ];


    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }


    protected static function newFactory()
    {
        return CategoryFactory::new();
    }


    public function newEloquentBuilder($query)
    {
        return new CategoryQueryBuilder($query);
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }



}
