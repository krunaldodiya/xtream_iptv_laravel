<?php

namespace App\Nova;

use App\Nova\Actions\BackupStream;
use App\Nova\Actions\SyncStream;

use Illuminate\Http\Request;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;

use Laravel\Nova\Http\Requests\NovaRequest;

class Stream extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Stream>
     */
    public static $model = \App\Models\Stream::class;

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
        'id', 'name', 'stream_id'
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

            BelongsTo::make('Xtream Account', 'xtream_account'),

            Text::make('Stream ID'),
            Text::make('Category ID')->sortable(),
            Text::make('Name'),
            Text::make('Url')->copyable(),
            Boolean::make('Working'),

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
            BackupStream::make()->standalone(),
            SyncStream::make()->standalone(),
        ];
    }
}
