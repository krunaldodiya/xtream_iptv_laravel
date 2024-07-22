<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $casts = [
        "can_paper_trade" => "boolean",
        "can_live_trade" => "boolean",
        'monthly_charges' => 'float',
    ];
}
