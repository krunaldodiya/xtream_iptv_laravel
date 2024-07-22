<?php

namespace App\Nova;

use App\Nova\Actions\BackupBaseSymbol;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class BaseSymbol extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BaseSymbol>
     */
    public static $model = \App\Models\BaseSymbol::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('exchange')->options([
                'NSE' => 'NSE',
                'BSE' => 'BSE',
            ])->sortable(),

            Select::make('type')->options([
                'Stock' => 'Stock',
                'Index' => 'Index',
            ])->sortable(),

            Text::make('key')->sortable(),
            Text::make('value')->sortable(),
            Text::make('weekly_expiry_day')->sortable(),
            Text::make('monthly_expiry_day')->sortable(),
            Number::make('lot_size')->sortable(),
            Number::make('strike_size')->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            BackupBaseSymbol::make()->standalone(),
        ];
    }
}
