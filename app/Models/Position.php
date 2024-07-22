<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;

    protected $casts = [
        'enter_price' => 'float',
        'exit_price' => 'float',
    ];

    public function broker_symbol()
    {
        return $this->belongsTo(BrokerSymbol::class);
    }

    public function risk_reward()
    {
        return $this->hasOne(RiskReward::class);
    }
}
