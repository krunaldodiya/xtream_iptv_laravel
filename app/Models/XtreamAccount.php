<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XtreamAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function stream_categories()
    {
        return $this->hasMany(StreamCategory::class);
    }
}
