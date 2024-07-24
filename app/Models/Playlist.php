<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function playlist_channels() {
        return $this->hasMany(PlaylistChannel::class);
    }
}
