<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    ];

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
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
