<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Models\PlaylistChannel;

class GenerateM3uPlaylist extends Action
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
        $playlist_id = request()->get('resources');

        $playlist_channels = PlaylistChannel::query()
            ->with(['playlist', 'channel.xtream_account', 'category'])
            ->where(['playlist_id' => $playlist_id])
            ->get();

        $epgUrl = "http://rstream.me/epg.xml.gz";

        $playlist_template = "#EXTM3U x-tvg-url=\"{$epgUrl}\"\n";

        foreach ($playlist_channels as $playlist_channel) {
            $streamId = $playlist_channel['channel']['stream_id'];

            $xtream_account = $playlist_channel['channel']['xtream_account'];
            
            $language = $playlist_channel['channel']['language']['name'];
            
            $country = $playlist_channel['channel']['country']['name'];
            
            $channelLogo = $playlist_channel['channel']['logo'];
            
            $channelName = $playlist_channel['name'];

            $category = $playlist_channel['category']['name'];

            $url = "{$xtream_account->server}/live/{$xtream_account->username}/{$xtream_account->password}/{$streamId}.ts";

            $playlist_template .= (
                "#EXTINF:-1 tvg-id=\"{$streamId}\" tvg-name=\"{$channelName}\" "
                . "tvg-country=\"{$country}\" tvg-language=\"{$language}\" "
                . "tvg-logo=\"{$channelLogo}\" group-title=\"{$category}\",{$channelName}\n{$url}\n"
            );
        }

        $file = "{$playlist_id}.m3u";

        Storage::disk('playlists')->put($file, $playlist_template);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
