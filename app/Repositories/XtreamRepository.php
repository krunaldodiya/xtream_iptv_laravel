<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Models\Epg;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Stream;
use App\Models\XtreamAccount;
use App\Models\PlaylistChannel;

class XtreamRepository implements XtreamRepositoryInterface
{
    public $epg_api_url;

    public $channel_api_url;

    public $client;

    public function __construct()
    {
        $this->epg_api_url = "https://www.tsepg.cf/epg.xml.gz";

        $this->channel_api_url = "https://www.tataplay.com/dth/read/core-api/packages/mp/channels/eyJhbGciOiJIUzI1NiJ9.e30.ZRrHA1JJJW8opsbCGfG_HACGpVUMN_a9IV7pAx_Zmeo";

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

    public function sync_epg()
    {
        $cacheKey = "get_epgs";
        $cacheDuration = 60 * 60;

        $epgs = Cache::remember($cacheKey, $cacheDuration, function () {
            $response = Http::get($this->epg_api_url);

            $epgs = [];

            if ($response->ok()) {
                $compressedData = $response->body();

                $decompressedData = gzdecode($compressedData);

                $xml = simplexml_load_string($decompressedData);

                $json = json_encode($xml);

                $array = json_decode($json, true);

                foreach ($array['channels']['channel'] as $channel) {
                    $epgs[] = [
                        'name' => $channel['display-name'],
                        'value' => $channel['@attributes']['id'],
                        'logo' => $channel['icon']['@attributes']['src'],
                    ];
                }
            }

            return $epgs;
        });

        if (!empty($epgs)) {
            $existing_epgs = Epg::all()->keyBy(['value']);

            $new_epgs = collect($epgs)
                ->reject(function ($channel) use ($existing_epgs) {
                    return $existing_epgs->has($channel['value']);
                });

            foreach ($new_epgs as $new_epg) {
                Epg::create([
                    'name' => $new_epg['name'],
                    'value' => $new_epg['value'],
                    'logo' => $new_epg['logo'],
                ]);
            }
        }

        return true;
    }

    public function generate_m3u_playlist($playlist_id) {
        $playlist_channels = PlaylistChannel::query()
            ->with([
                'playlist',
                'channel.stream.xtream_account',
                'channel.category',
                'channel.language',
                'channel.country'
            ])
            ->where(['playlist_id' => $playlist_id])
            ->get();

        $playlist_template = "#EXTM3U x-tvg-url=\"{$this->epg_api_url}\"\n";

        foreach ($playlist_channels as $playlist_channel) {
            $channel = $playlist_channel['channel'];

            $logo = $channel['logo'];
            
            $name = $channel['name'];

            $number = $channel['number'];

            $epg = $channel['epg'];

            $language = $channel['language']['name'];

            $country = $channel['country']['name'];

            $category = $channel['category']['name'];

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
}
