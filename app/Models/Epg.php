<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epg extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function channel() {
        return $this->hasOne(Channel::class);
    }
}
