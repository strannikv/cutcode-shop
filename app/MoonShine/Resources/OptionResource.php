<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Option;
use Illuminate\Database\Eloquent\Model;

use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Resources\Resource;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Actions\FiltersAction;

class OptionResource extends Resource
{
	public static string $model = Option::class;

	public static string $title = 'Option';

	public function fields(): array
	{
		return [
            ID::make()->sortable(),
            Text::make('Title')->sortable(),
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
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
