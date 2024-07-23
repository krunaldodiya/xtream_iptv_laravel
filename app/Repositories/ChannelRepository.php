<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

use App\Models\ChannelCategory;
use App\Models\Channel;

class ChannelRepository implements ChannelRepositoryInterface
{
    private string $server;

    private string $username;

    private string $password;

    public function __construct()
    {
        $this->server = config("services.xtream.server");
        $this->username = config('services.xtream.username');
        $this->password = config('services.xtream.password');
    }

    public function sync_channels()
    {  
        $channel_categories = ChannelCategory::all();

        $responses = Http::pool(fn ($pool) => 
            $channel_categories->map(fn ($channel_category) => 
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
                            'channel_name' => $channel['name'], 
                            'category_id' => $channel['category_id'],
                            'channel_number' => $channel['num'],
                            'channel_language' => "Hindi",
                            'channel_country' => "India",
                            'channel_logo' => $channel['stream_icon'],
                        ]
                    );
                }
            }
        }
    }
}
