<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class BrokerSymbol extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BrokerSymbol>
     */
    public static $model = \App\Models\BrokerSymbol::class;

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

            BelongsTo::make('Base Symbol', 'base_symbol', 'App\Nova\BaseSymbol'),

            Text::make('broker_title')->sortable(),
            Text::make('exchange')->sortable(),
            Text::make('market_type')->sortable(),
            Text::make('segment_type')->sortable(),
            Text::make('expiry_date')->sortable(),
            Text::make('expiry_period')->sortable(),
            Text::make('strike_price')->sortable(),
            Text::make('option_type')->sortable(),
            Text::make('symbol_name')->sortable(),
            Text::make('symbol_token')->sortable(),
            Text::make('exchange_token')->sortable(),
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
        return [];
    }
}
