<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Select;

use App\Models\Channel;
use App\Models\Epg;

class AssignEpg extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $epg = Epg::find($fields->epg);

        $channel = Channel::query()
            ->where('id', request()->get('resources'))
            ->update([
                'epg' => $epg['value'],
                'logo' => "https://logo.iptveditor.com/{$epg['logo']}.png",
            ]);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $epgs = Epg::pluck('name', 'id');

        return [
            Select::make('Epg')->options($epgs)->searchable()
        ];
    }
}
