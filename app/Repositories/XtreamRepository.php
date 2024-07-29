<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Epg;
use App\Models\Category;
use App\Models\Language;
use App\Models\Channel;
use App\Models\XtreamAccount;
use App\Models\Stream;
use App\Models\StreamCategory;
use App\Models\Playlist;

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

    public function sync_categories(XtreamAccount $xtream_account)
    {
        $cacheKey = "sync_categories:{$xtream_account->server}";
        $cacheDuration = 60 * 60;

        $categories = Cache::remember($cacheKey, $cacheDuration, function () use ($xtream_account) {
            $response = $this->client->get("{$xtream_account->server}/player_api.php", [
                    'username' => $xtream_account->username,
                    'password' => $xtream_account->password,
                    'action' => 'get_live_categories',
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });

        if (!empty($categories)) {
            $existing_categories = StreamCategory::query()
                ->where('xtream_account_id', $xtream_account->id)
                ->get()
                ->keyBy(['category_id']);

            $new_categories = collect($categories)->reject(function ($category) use ($existing_categories) {
                return $existing_categories->has($category['category_id']);
            });

            foreach ($new_categories as $new_stream) {
                StreamCategory::create([
                    'xtream_account_id' => $xtream_account['id'],
                    'category_id' => $new_stream['category_id'],
                    'category_name' => $new_stream['category_name'],
                ]);
            }
        }
    }

    public function sync_streams(XtreamAccount $xtream_account)
    {
        $cacheKey = "sync_streams:{$xtream_account->server}";
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
            $existing_streams = Stream::query()
                ->where(['xtream_account_id' => $xtream_account->id])
                ->pluck('stream_id');

            $existing_stream_categories = StreamCategory::query()
                ->where(['xtream_account_id' => $xtream_account->id, 'active' => true])
                ->pluck('category_id');

            $new_streams = collect($streams)
                ->filter(function ($stream) use ($existing_streams) {
                    return !$existing_streams->contains($stream['stream_id']);
                })
                ->filter(function ($stream) use ($existing_stream_categories) {
                    return $existing_stream_categories->contains($stream['category_id']);
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

    public function sync_epgs()
    {
        $cacheKey = "sync_epgs";
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
            $existing_epgs = Epg::pluck('value');

            $new_epgs = collect($epgs)
                ->filter(function ($epg) use ($existing_epgs) {
                    return !$existing_epgs->contains($epg['value']);
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

    public function sync_channels()
    {        
        $cacheKey = "sync_channels";
        $cacheDuration = 60 * 60;

        $channels = Cache::remember($cacheKey, $cacheDuration, function () {
            $response = Http::get($this->channel_api_url);

            $channels = [];

            if ($response->ok()) {
                $array = $response->json();

                $categories = Category::pluck('id', 'name');

                $languages = Language::pluck('id', 'name');

                foreach ($array['data']['packages'] as $package) {
                    foreach ($package['items'] as $item) {
                        $language = count($item['language']) == 1 ? $item['language'][0]: "Others";

                        $pack_friendly_name = $item['pack_friendly_name'];

                        $pack_name = $item['pack_name'];

                        $slug = Str::of($pack_friendly_name)->slug('-');

                        $logo = "https://www.tataplay.com/s3-api/v1/assets/channels/{$slug}.gif";

                        $channels[] = [
                            'pack_friendly_name' => $pack_friendly_name,
                            'pack_name' => $pack_friendly_name,
                            'channel_name' => $item['bouquet_channels'][0]['CHANNEL_NAME'],
                            'number' => $item['bouquet_channels'][0]['EPG_NUMBER'],
                            'logo' => $logo,
                            'stream_id' => 1,
                            'country_id' => 2,
                            'language_id' => $languages[$language],
                            'category_id' => $categories[$item['category']],
                        ];
                    }
                }
            }

            return $channels;
        });

        if (!empty($channels)) {
            $existing_channels = Channel::all()->keyBy(['number']);

            $new_channels = collect($channels)
                ->reject(function ($channel) use ($existing_channels) {
                    return $existing_channels->has($channel['number']);
                });

            foreach ($new_channels as $new_channel) {
                Channel::create([
                    'name' => $new_channel['pack_friendly_name'],
                    'number' => $new_channel['number'],
                    'logo' => $new_channel['logo'],
                    'stream_id' => $new_channel['stream_id'],
                    'country_id' => $new_channel['country_id'],
                    'language_id' => $new_channel['language_id'],
                    'category_id' => $new_channel['category_id'],
                ]);
            }
        }

        return true;
    }

    public function generate_m3u_playlist($playlist_id) {
        $playlist = Playlist::query()
            ->with([
                'channels.stream.xtream_account',
                'channels.category',
                'channels.language',
                'channels.country',
                'channels.epg'
            ])
            ->where(['id' => $playlist_id])
            ->first();

        $playlist_template = "#EXTM3U x-tvg-url=\"{$this->epg_api_url}\"\n";

        foreach ($playlist->channels as $channel) {
            $logo = $channel['logo'];
            
            $name = $channel['name'];

            $number = $channel['number'];
            
            $epg = $channel['epg'] ? $channel['epg']['value']: "none";

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
