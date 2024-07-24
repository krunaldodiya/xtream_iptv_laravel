<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\Category;
use App\Models\Channel;
use App\Models\XtreamAccount;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function sync_channels_by_categories(XtreamAccount $xtream_account)
    {
        $categories = Category::all();

        $responses = Http::pool(fn ($pool) => 
            $categories->map(fn ($channel_category) => 
                $pool->as($channel_category->category_id)->get("{$this->server}/player_api.php", [
                    'username' => $this->username,
                    'password' => $this->password,
                    'action' => 'get_live_streams',
                    'category_id' => $channel_category->category_id
                ])
            )
        );

        foreach ($responses as $response) {
            if ($response->successful()) {
                $channels = $response->json();

                foreach ($channels as $channel) {
                    Channel::firstOrCreate(
                        ['stream_id' => $channel['stream_id']], 
                        [
                            'name' => $channel['name'],
                            'category_id' => 1,
                            'language_id' => 1,
                            'country_id' => 1,
                            'number' => $channel['num'],
                            'logo' => $channel['stream_icon'],
                        ]
                    );
                }
            }
        }
    }

    public function sync_all_channels(XtreamAccount $xtream_account)
    {
        $cacheKey = 'live_streams_response';
        $cacheDuration = 60 * 60;

        $channels = Cache::remember($cacheKey, $cacheDuration, function () {
            $response = Http::get("{$xtream_account->server}/player_api.php", [
                'username' => $xtream_account->username,
                'password' => $xtream_account->password,
                'action' => 'get_live_streams',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });

        if (!empty($channels)) {
            $existingChannels = Channel::all()->keyBy('stream_id');
            $channelsCollection = collect($channels);

            $newChannels = $channelsCollection->reject(function ($channel) use ($existingChannels) {
                return $existingChannels->has($channel['stream_id']);
            });

            foreach ($newChannels as $channel) {
                Channel::create([
                    'stream_id' => $channel['stream_id'],
                    'name' => $channel['name'],
                    'category_id' => 1,
                    'language_id' => 1,
                    'country_id' => 1,
                    'number' => $channel['num'],
                    'logo' => $channel['stream_icon'],
                ]);
            }
        }
    }

    public function sync_categories(XtreamAccount $xtream_account) {
        $url = "http://opplex.tv:8080/player_api.php?username=hitesh&password=hitesh123&action=get_live_categories";
    }
}
