<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $appends = ['url'];

    public function xtream_account() {
        return $this->belongsTo(XtreamAccount::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function getUrlAttribute()
    {
        $xtream_account = $this->xtream_account;

        $server = $xtream_account->server;

        $username = $xtream_account->username;

        $password = $xtream_account->password;

        $stream_id = $this->stream_id;

        return "{$server}/live/{$username}/{$password}/{$stream_id}.ts";
    }
}
