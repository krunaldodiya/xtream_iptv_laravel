<?php

namespace App\Nova;

use App\Nova\Actions\BackupTradingCalendar;
use App\Nova\Actions\FetchTradingCalendar;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class TradingCalendar extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TradingCalendar>
     */
    public static $model = \App\Models\TradingCalendar::class;

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
            Text::make('Description')->sortable(),
            Date::make('Date')->sortable(),
            MultiSelect::make('Closed Exchanges')
                ->options([
                    'NSE' => 'NSE',
                    'NFO' => 'NFO',
                    'BSE' => 'BSE',
                    'BFO' => 'BFO',
                    'CDS' => 'CDS',
                    'BCD' => 'BCD',
                    'MCX' => 'MCX',
                ])
                ->onlyOnForms(),
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
            BackupTradingCalendar::make()->standalone(),
            FetchTradingCalendar::make()->standalone(),
        ];
    }
}
