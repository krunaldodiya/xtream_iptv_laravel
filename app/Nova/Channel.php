<?php

namespace App\Nova;

use App\Nova\Actions\BackupChannel;
use App\Nova\Actions\SyncChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;

use Laravel\Nova\Http\Requests\NovaRequest;

class Channel extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Channel>
     */
    public static $model = \App\Models\Channel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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

            Text::make('Stream ID'),
            Text::make('Category ID')->sortable(),
            Text::make('Name'),

            BelongsTo::make('Xtream Account', 'xtream_account'),
            BelongsTo::make('Language')->sortable(),
            BelongsTo::make('Country')->sortable(),

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
            BackupChannel::make()->standalone(),
            SyncChannel::make()->standalone(),
        ];
    }
}
