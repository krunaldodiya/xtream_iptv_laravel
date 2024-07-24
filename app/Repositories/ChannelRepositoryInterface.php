<?php

namespace App\Repositories;

interface ChannelRepositoryInterface
{
    public function sync_channels_by_categories();
    public function sync_all_channels();
    public function sync_categories();
}
