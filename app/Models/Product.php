<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'sorting',
        'on_home_page',
    ];


    protected function thumbnailDir(): string
    {
        return 'products';
    }


    protected $casts = [
        'price' => PriceCast::class,
    ];


    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function scopeFiltered(Builder $query)
    {
        $query->when(request('filters.brands'), function (Builder $q){
            $q->whereIn('brand_id', request('filters.brands'));
        })
            ->when(request('filters.price'), function (Builder $q){
                $q->whereBetween('price', [
                    request('filters.price.from', 0) * 100,
                    request('filters.price.to', 10000) * 100
                ]);
            });
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function (Builder $q){
            $column = request()->str('sort');

            if ($column->contains(['price', 'title'])){
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy((string) $column->remove('-'), $direction);
            }


        });
    }


    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


}
