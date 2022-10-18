<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    protected static function boot()
    {
        parent::boot();

        //todo 3 lesson
        static::creating(function ($model) {
            $model->slug = $model->slug ?? str($model->title)->slug();
        });
    }
}
