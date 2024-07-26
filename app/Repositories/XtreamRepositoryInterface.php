<?php

namespace App\Repositories;

use App\Models\XtreamAccount;

interface XtreamRepositoryInterface
{
    public function sync_streams(XtreamAccount $xtream_account);
    public function sync_epgs();
    public function sync_channels();
    public function generate_m3u_playlist(int $playlist_id);
}
