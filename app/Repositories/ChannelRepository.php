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
                $pool->as($channel_category->category_id)->get("{$xtream_account->server}/player_api.php", [
                    'username' => $xtream_account->username,
                    'password' => $xtream_account->password,
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

        $channels = Cache::remember($cacheKey, $cacheDuration, function () use ($xtream_account) {
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
            $existing_channels = Channel::all()->keyBy('stream_id');

            $newChannels = collect($channels)->reject(function ($channel) use ($existing_channels) {
                return $existing_channels->has($channel['stream_id']);
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
        $response = Http::get("{$xtream_account->server}/player_api.php", [
            'username' => $xtream_account->username,
            'password' => $xtream_account->password,
            'action' => 'get_live_categories',
        ]);
    }
}
