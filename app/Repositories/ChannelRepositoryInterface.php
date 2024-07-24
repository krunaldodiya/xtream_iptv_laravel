<?php

namespace App\Repositories;

use App\Models\XtreamAccount;

interface ChannelRepositoryInterface
{
    public function sync_channels_by_categories(XtreamAccount $xtream_account);
    public function sync_all_channels(XtreamAccount $xtream_account);
    public function sync_categories(XtreamAccount $xtream_account);
}
