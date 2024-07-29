<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function xtream_account() {
        return $this->belongsTo(XtreamAccount::class);
    }

    public function streams() {
        return $this->hasMany(Stream::class);
    }
}
