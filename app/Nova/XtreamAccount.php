<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Http\Requests\NovaRequest;

use App\Nova\Actions\BackupXtreamAccount;
use App\Nova\Actions\GenerateStreamingUrl;
use App\Nova\Actions\SyncStreamCategory;

class XtreamAccount extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\XtreamAccount>
     */
    public static $model = \App\Models\XtreamAccount::class;

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
        return [
            ID::make()->sortable(),
            Text::make('Name'),
            Text::make('Server'),
            Text::make('Username'),
            Text::make('Password'),

            HasMany::make("Streams", 'streams'),
            HasMany::make("Stream Categories", 'stream_categories'),
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
            BackupXtreamAccount::make()->standalone(),
            GenerateStreamingUrl::make(),
            SyncStreamCategory::make(),
        ];
    }
}
