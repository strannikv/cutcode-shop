<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
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
