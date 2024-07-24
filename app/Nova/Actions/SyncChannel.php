<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Models\XtreamAccount;
use App\Repositories\ChannelRepositoryInterface;

class SyncChannel extends Action
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
        $xtream_account = XtreamAccount::find($fields->xtream_account);

        $channelRepositoryInterface = resolve(ChannelRepositoryInterface::class);

        $channelRepositoryInterface->sync_all_channels($xtream_account);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $xtream_accounts = XtreamAccount::pluck('server', 'id');

        return [
            Select::make("Xtream Account")->options($xtream_accounts),
        ];
    }
}
