<?php

namespace App\Repositories;

use App\Models\XtreamAccount;

interface XtreamRepositoryInterface
{
    public function sync_streams_by_categories(XtreamAccount $xtream_account);
    public function sync_all_streams(XtreamAccount $xtream_account);
    public function sync_categories(XtreamAccount $xtream_account);
    public function generate_m3u_playlist(int $playlist_id);
    public function sync_all_channels();
}
