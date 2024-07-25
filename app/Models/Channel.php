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
}
