<?php

namespace App\Nova;

use App\Nova\Actions\BackupEpg;
use App\Nova\Actions\SyncEpg;
use App\Nova\Actions\AssignEpgToChannels;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;

use Laravel\Nova\Http\Requests\NovaRequest;

class Epg extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Epg>
     */
    public static $model = \App\Models\Epg::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Get the value used to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->name . ' | ' . $this->value;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $placeholder_logo = "/images/404.png";

        return [
            ID::make()->sortable(),
            Text::make('name')->sortable(),
            Text::make('value')->sortable(),

            Text::make('Logo', 'logo')->onlyOnForms(),

            Image::make('Logo', 'logo')
                ->thumbnail(function ($value) use ($placeholder_logo) {
                    return $value ? $value : $placeholder_logo; 
                })
                ->exceptOnForms(),
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
            BackupEpg::make()->standalone(),
            SyncEpg::make()->standalone(),
            AssignEpgToChannels::make(),
        ];
    }
}
