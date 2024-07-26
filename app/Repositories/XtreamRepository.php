<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use App\Models\Channel;
use App\Models\Stream;
use App\Models\XtreamAccount;
use App\Models\PlaylistChannel;

class XtreamRepository implements XtreamRepositoryInterface
{
    public $client;

    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Accept' => 'application/json', 
            'Content-Type' => 'application/json', 
            'User-Agent' => '*'
        ]);
    }

    public function sync_all_streams(XtreamAccount $xtream_account)
    {
        $cacheKey = "get_live_streams:{$xtream_account->server}";
        $cacheDuration = 60 * 60;

        $streams = Cache::remember($cacheKey, $cacheDuration, function () use ($xtream_account) {
            $response = $this->client->get("{$xtream_account->server}/player_api.php", [
                    'username' => $xtream_account->username,
                    'password' => $xtream_account->password,
                    'action' => 'get_live_streams',
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });

        if (!empty($streams)) {
            $existing_streams = Channel::all()->keyBy(['stream_id', 'category_id']);

            $new_streams = collect($streams)->reject(function ($channel) use ($existing_streams) {
                return $existing_streams->has($channel['stream_id']);
            });

            foreach ($new_streams as $new_stream) {
                Stream::create([
                    'xtream_account_id' => $xtream_account['id'],
                    'stream_id' => $new_stream['stream_id'],
                    'category_id' => $new_stream['category_id'],
                    'name' => $new_stream['name'],
                    'logo' => $new_stream['stream_icon'],
                ]);
            }
        }
    }

    public function generate_m3u_playlist($playlist_id) {
        $playlist_channels = PlaylistChannel::query()
            ->with([
                'playlist',
                'channel.stream.xtream_account',
                'channel.epg',
                'channel.category',
                'channel.language',
                'channel.country'
            ])
            ->where(['playlist_id' => $playlist_id])
            ->get();
        
        return $playlist_channels;

        $epgUrl = "http://rstream.me/epg.xml.gz";

        $playlist_template = "#EXTM3U x-tvg-url=\"{$epgUrl}\"\n";

        foreach ($playlist_channels as $playlist_channel) {
            $channel = $playlist_channel['channel'];

            $logo = $channel['logo'];
            
            $name = $channel['name'];

            $number = $channel['number'];

            $language = $channel['language']['name'];

            $country = $channel['country']['name'];

            $category = $channel['category']['name'];

            $epg = $channel['epg']['value'];

            $url = $channel['stream']['url'];

            $playlist_template .= (
                "#EXTINF:-1 tvg-id=\"{$epg}\" tvg-chno=\"{$number}\" tvg-name=\"{$name}\" "
                . "tvg-country=\"{$country}\" tvg-language=\"{$language}\" "
                . "tvg-logo=\"{$logo}\" group-title=\"{$category}\",{$name}\n{$url}\n"
            );
        }

        $file = "{$playlist_id}.m3u";

        Storage::disk('playlists')->put($file, $playlist_template);
    }


    public function sync_all_channels()
    {
        $cacheKey = "get_channels";
        $cacheDuration = 60 * 60;

        $channels = Cache::remember($cacheKey, $cacheDuration, function () {
            $response = $this->client->get("https://ts-api.videoready.tv/content-detail/pub/api/v1/channels?limit=2000");

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });

        if (!empty($channels)) {
            $existing_channels = Channel::all()->keyBy(['number']);

            $new_channels = collect($channels['data']['list'])
                ->reject(function ($channel) use ($existing_channels) {
                    return $existing_channels->has($channel['id']);
                });

            foreach ($new_channels as $new_channel) {
                Channel::create([
                    'number' => $new_channel['id'],
                    'name' => $new_channel['title'],
                    'logo' => $new_channel['image'],
                    'stream_id' => 1,
                    'category_id' => 1,
                    'language_id' => 1,
                    'country_id' => 1,
                ]);
            }
        }

        return true;
    }
}
