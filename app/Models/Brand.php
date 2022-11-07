<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'sorting',
        'on_home_page',
    ];

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


}
