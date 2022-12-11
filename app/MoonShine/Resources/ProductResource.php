<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Actions\ExportAction;
use Leeto\MoonShine\Decorations\Tab;
use Leeto\MoonShine\Fields\BelongsTo;
use Leeto\MoonShine\Fields\BelongsToMany;
use Leeto\MoonShine\Fields\Image;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Filters\BelongsToFilter;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
    public static string $model = Product::class;

    public static string $title = 'Product';

    public static array $with = [
        'brand',
        'categories',
        'properties',
        'optionValues',

    ];

    public function fields(): array
    {
        return [
            Tab::make('Basic', [
                ID::make()->sortable(),
                Text::make('Title')->sortable(),
                BelongsTo::make('brand'),

                Text::make('Price', resource: function ($item){
                    return $item->price->raw();
                }),

                Image::make('Thumbnail')
                    ->dir('images/products')
                    ->withPrefix('/storage/'),
            ]),

            Tab::make('Categories', [
                BelongsToMany::make('Categories', 'categories', resource: 'title')
                    ->hideOnIndex(),
            ]),

            Tab::make('Properties', [
                BelongsToMany::make('properties', resource: 'title')
                    ->fields([
                        Text::make('value'),
                    ])
                    ->hideOnIndex(),
            ]),

            Tab::make('Options', [
                BelongsToMany::make('optionValues', resource: 'title')
                    ->fields([
                        Text::make('value'),
                    ])
                    ->hideOnIndex(),
            ]),


        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make('Brand')
            ->searchable(),
            BelongsToFilter::make('categories'),
        ];
    }

    public function actions(): array
    {
        return [
            ExportAction::make('Export'),
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
