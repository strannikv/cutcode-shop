<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;

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


    protected static function newFactory()
    {
        return CategoryFactory::new();
    }


    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }



}
