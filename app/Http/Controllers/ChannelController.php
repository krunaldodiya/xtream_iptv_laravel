<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function stream(Request $request) {
        $xtream_host = config('services.xtream.host');
        $xtream_username = config('services.xtream.username');
        $xtream_password = config('services.xtream.password');
        $stream_id = $request->route('stream_id');

        $url = "{$xtream_host}/live/{$xtream_username}/{$xtream_password}/{$stream_id}.ts";

        return redirect($url, 301);
    }
}