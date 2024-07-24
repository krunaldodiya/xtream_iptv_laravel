<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistChannel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function playlist() {
        return $this->belongsTo(Playlist::class);
    }

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
